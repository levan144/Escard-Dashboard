<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Company;
use App\Models\Category;
use App\Models\User;
use App\Models\DeletedUser;
use Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordMail;
use Illuminate\Support\Facades\Validator;
use \Carbon\Carbon;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the users list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

      // Retrieve all users
    // Retrieve all users
    $users = User::all();
    $companies = Company::all();
    // Calculate the number of days left for each user
    $users = $users->map(function ($user) {
        $activeUntil = $user->active_until;

        if ($activeUntil) {
            try {
                // Create a Carbon date object from the 'Y-m-d' formatted date
                $activeUntilDate = Carbon::createFromFormat('Y-m-d H:i:s', $activeUntil);
                
                // Calculate the number of days left before active_until date
                $daysLeft = now()->diffInDays($activeUntilDate);
                $user->active_until_days = $daysLeft;
            } catch (\Exception $e) {
                // Handle any parsing errors here, if necessary
                $user->active_until_days = null;
            }
        } else {
            $user->active_until_days = null; // Set to null if active_until is not set
        }

        return $user;
    });

    return view('users.index', compact('users', 'companies'));
    }
    
    /**
     * Show the Company create form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $companies = Company::all();
        
        return view('users.create', compact('companies'));
    }
    
    /**
     * Show the Company edit form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $companies = Company::all();
        $user = User::FindOrFail($id);
        return view('users.edit', compact('companies','user'));
    }
    
    /**
     * Company Store Method
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->company_id = $request->company_id ?? null;
        $user->card_id = $request->card_id ?? null;
        $user->sid = $request->sid;
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('users')->with('success','User Created.');
    }
    
    /**
     * Company Update Method
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $id)
    {
       $user = User::FindOrFail($id);
       $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'phone' => 'required|string',
        'company_id' => 'nullable|integer',
        // 'card_id' => 'nullable|integer',
        'sid' => 'required|string',
        'password' => 'nullable|string|min:8',
        'status' => 'nullable|boolean',
    ]);
    if ($validator->fails()) {
        return redirect()->back()->with('error', $validator->errors());
       

    }
    $data = $request->only(['name', 'lastname', 'email', 'phone', 'company_id', 'card_id', 'sid']);
    $data['password'] = $request->input('password') ? Hash::make($request->input('password')) : $user->password;
    
    $data['deleted_at'] = $request->boolean('status') ? null : now();
    $user->update($data);
    return redirect()->route('users')->with('success', 'User Updated.');

    }
    
    /**
     * Company Delete Method
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users')->with('success','User Deleted.');
        
    }
    
    public function import(Request $request)
    {
        try {
             // Validate the uploaded file
            $request->validate([
                'attachment' => 'required|mimes:xlsx,xls,csv'
            ]);
    
            // Get the uploaded file
            $file = $request->file('attachment');
    
            // Import users using the UsersImport class
            $import = new UsersImport;
            Excel::import($import, $file);
            $import->importComplete();
            
            // Redirect back or to a specific route after import
           // Replace the old redirect line in your controller with this
            if ($import->hasFailures()) {
                return redirect()->back()->with('error', 'There were errors during the import process. Please check the error messages.');
            } else {
                return redirect()->back()->with('success', 'Users imported successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    private function generatePassword()
    {
        // Generate a random password
        return bin2hex(random_bytes(6));
    }
    
    public function generateUserPassword($user_id) {
        try {
            
            $user = User::findOrFail($user_id);
            $password = $this->generatePassword();
            $user->password = Hash::make($password);
            $user->save();
            Mail::to($user->email)->cc('info@escard.ge')->send(new PasswordMail($password, $user->email));
            return redirect()->back()->with('success', 'Email has been sent with new generated password');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    public function enable($user_id) {
        try {
            $user = User::findOrFail($user_id);
            $user->deleted_at = null;
            $user->save();
            return redirect()->back()->with('success', 'User Activated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    public function deleted_users() {
        $users = DeletedUser::all();
        return view('users.deleted_users', compact('users'));
    }
    
    public function massDelete(Request $request)
    {
        $company_id = $request->input('company_id');
        $password = $request->input('password'); // Assuming you have a 'password' field in your request
    
        // Validate the password
        if (!Hash::check($password, auth()->user()->password)) {
            return redirect()->back()->with('error', 'Invalid password');

        }
        $company_id = $request->input('company_id');
        if ($company_id ) {
            // Delete users by company ID
            User::where('company_id', $company_id)->delete();
            return redirect()->back()->with('success', 'Users from the company deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Invalid request. please choose the company');
        }
    }
}
