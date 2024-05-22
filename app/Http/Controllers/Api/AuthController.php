<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use MikeMcLin\WpPassword\Facades\WpPassword;
use \Carbon\Carbon;
class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => __('auth.validation'),
                    'errors' => $validateUser->errors()
                ], 401);
            }

            

            if(!Auth::attempt($request->only(['email', 'password']))){
                $user_model = User::where('email', $request->email)->first();
                if (!$user_model or ($user_model && !WpPassword::check($request->password, $user_model->password))) {
                    return response()->json([
                    'status' => false,
                    'message' => __('auth.failed'),
                ], 401);
                }
            }
            
            
            $user = User::where('email', $request->email)->first();
            $activeUntil = $user->active_until ? Carbon::parse($user->active_until) : null;
            $currentDateTime = Carbon::now();
            if ($activeUntil && $activeUntil < $currentDateTime) {
                return response()->json([
                    'status' => false,
                    'message' => __('auth.expired'),
                ], 401);
            }
            if(!$user->company_id && !$activeUntil) {
                return response()->json([
                    'status' => false,
                    'message' => __('auth.expired'),
                ], 401);
            }
            if($user->deleted_at){
                return response()->json([
                    'status' => false,
                    'message' => __('auth.inactive'),
                ], 401);
            }
            
            if(isset($user->getCompany) && (!$user->getCompany->active || $user->getCompany->deleted_at)){
                return response()->json([
                    'status' => false,
                    'message' => 'Company is inactive',
                ], 401);
            }
            
            // Delete all tokens for the user
            $user->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'data' => $user->load(['getCompany', 'getCard']),
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function wp_create_user(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8', // Make sure to validate as necessary
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password, // Never store plain passwords!
        ]);

        // Optionally, you can return a response or some data
        return response()->json(['message' => 'User created successfully.', 'user' => $user], 201);
    }
    
    public function wp_sync_user(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'active_until' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
    
        $user->active_until = $request->active_until;
        $user->save();
    
        return response()->json(['message' => 'Subscription updated successfully.'], 200);
    }
    
    public function check_email(Request $request) {
    $email = $request->input('email'); // Get the email from the request

    // Check if the email exists in the users table
    $user = User::where('email', $email)->first();
        if ($user) {
            // Email is registered
            return response()->json(['status' => true, 'message' => 'Email is registered'], 200);
        } else {
            // Email is not registered
            return response()->json(['status' => false, 'message' => 'Email is not registered'], 404);
        }
    }
    
    public function wp_sync_password(Request $request) {
        $password = $request->password;
        $email = $request->email;
        
        
        $user = User::where('email', $email)->firstOrFail();
        $user->password = Hash::make($password);
        $user->save();
        return response()->json(['status' => true, 'message' => 'password updated'], 200);
    }
}