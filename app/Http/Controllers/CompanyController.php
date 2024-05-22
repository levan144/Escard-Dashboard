<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Category;

class CompanyController extends Controller
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
     * Show the companies list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $companies = Company::all();
        
        return view('companies.index', compact('companies'));
    }
    
    /**
     * Show the Company create form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $categories = Category::all();
        
        return view('companies.create', compact('categories'));
    }
    
    /**
     * Show the Company edit form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $categories = Category::all();
        return view('companies.edit', compact('company','categories'));
    }
    
    /**
     * Company Store Method
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $company = new Company;
        $company->name = $request->name;
        $company->phone = $request->phone;
        $company->working_hours = $request->working_hours;
        $company->website = $request->website;
        $company->category_id = $request->category_id;
        $company->address = $request->address;
        if($request->file('featured_image')){
            $file= $request->file('featured_image');
            $extension = $file->getClientOriginalExtension();
            $filename= date('YmdHi').time() . '.' . $extension;
            $file-> move(public_path('/featured_images'), $filename);
            $company->featured_image = env('APP_URL') . '/featured_images/' . str_replace(' ', '%20', $filename);
        }
        $company->active = $request->status;
        $company->save();
        
        return redirect()->route('companies')->with('success','Company Created.');
    }
    
    /**
     * Company Update Method
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $company->name = $request->name;
        $company->working_hours = $request->working_hours;
        $company->address = $request->address;
        
        $company->phone = $request->phone;
        $company->website = $request->website;
        $company->category_id = $request->category_id;
        
        if($request->file('featured_image')){
            $file= $request->file('featured_image');
            $extension = $file->getClientOriginalExtension();
            $filename= date('YmdHi').time() . '.' . $extension;
            $file-> move(public_path('/featured_images'), $filename);
            $company->featured_image = env('APP_URL') . '/featured_images/' . str_replace(' ', '%20', $filename);
        }
        $company->active = $request->status;
        $company->save();
        if($company->getOffers()){
            $company->getOffers()->update(['category_id' => $company->category_id]);
        }
        return redirect()->route('companies')->with('success','Company Updated.');
    }
    
    /**
     * Company Delete Method
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($id)
    {
        $company = Company::FindOrFail($id);
        $company->delete();
        return redirect()->route('companies')->with('success','Company Deleted.');
        
    }
    
    public function pause($id) {
        $company = Company::FindOrFail($id);
        $company->active = false;
        $company->save();
        return redirect()->route('companies')->with('success','Company Paused and is InActive now.');
    }
    
    public function enable($id) {
        $company = Company::FindOrFail($id);
        $company->active = true;
        $company->deleted_at = null;
        $company->save();
                return redirect()->route('companies')->with('success','Company Enabled with all users');

    }
}
