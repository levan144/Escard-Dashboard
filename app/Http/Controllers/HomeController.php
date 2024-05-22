<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Setting;
use App\Models\Offer;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $companies = Company::all()->count();
        $users = User::all()->count();
        $active_users = User::whereNotNull('card_id')->whereNull('deleted_at')
        // ->WhereHas('getCompany', function ($subquery) {
        //       $subquery->where('active', 1);
        //   })
          ->count();
        return view('home', compact('companies', 'users', 'active_users'));
    }
    
    /**
     * Show the application Settings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings()
    {
       
        
        return view('settings_language_choose');
    }
    
    /**
     * Show the application Settings.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function settings_lang($lang = 'ka')
    {
        $settings = Setting::all();
        $offers = Offer::all();
        $welcome_screens = json_decode(Setting::where('title', 'welcome_screens')->where('language', $lang)->first()->value, true);
        $register_screens = json_decode(Setting::where('title', 'register_screens')->where('language', $lang)->first()->value, true);
        $homepage_screens = json_decode(Setting::where('title', 'homepage')->where('language', $lang)->first()->value ?? '{}', true);
        
        return view('settings', compact('welcome_screens', 'register_screens','homepage_screens','offers', 'lang'));
    }
    
    public function update(Request $request, $lang = 'ka') {
        $type = $request->type;
        if($type === 'general' ){
            if($request->file('logo')){
                $settings_logo = Setting::where('title', 'logo')->first();
                $file= $request->file('logo');
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file-> move(public_path('/general'), $filename);
                $settings_logo->value = 'https://dashboard.escard.ge/general/' . $filename;
                $settings_logo->save();
            }
            
            if($request->file('welcome_illustration')){
                $settings_illustration = Setting::where('title', 'welcome_illustration')->first();
                $file= $request->file('welcome_illustration');
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file-> move(public_path('/general'), $filename);
                $settings_illustration->value = 'https://dashboard.escard.ge/general/' . $filename;
                $settings_illustration->save();
            }
        }
        
        if($type === 'welcome_screens'){
            $settings = Setting::where('title', 'welcome_screens')->where('language', $lang)->first();
            $settings->value = $request->welcome_screens;
            
            $settings->save();
        }
        
        if($type === 'register_screens' ){
            $settings = Setting::where('title', 'register_screens')->where('language', $lang)->first();
            $settings->value = $request->register_screens;
            
            if($request->file('barcode')){
                $barcode = Setting::where('title', 'barcode')->first();
                $file= $request->file('barcode');
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file-> move(public_path('/general'), $filename);
                $barcode->value = 'https://dashboard.escard.ge/general/' . $filename;
                $barcode->save();
            }
            $settings->save();
        }
        
        if($type === 'homepage' ){
            $settings = Setting::where('title', 'homepage')->where('language', $lang)->first();
            $settings->value = $request->homepage;
            $settings->save();
        }
        return redirect()->route('settings')->with('success','Settings Updated.');
    }
 
}
