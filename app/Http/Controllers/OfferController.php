<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Offer;

class OfferController extends Controller
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
        $offers = Offer::all();
        
        return view('offers.index', compact('offers'));
    }
    
    /**
     * Show the Company create form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $companies = Company::all();
        
        return view('offers.create', compact('companies'));
    }
    
    /**
     * Show the Company edit form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        
        $offer = Offer::findOrFail($id);
        $companies = Company::all();
        $benefits = $offer->getTranslations('benefits');
        return view('offers.edit', compact('offer','companies', 'benefits'));
    }
    
    /**
     * Company Store Method
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $offer = new Offer;
        $offer->name = $request->name;
        $offer->subtitle = $request->subtitle;
        $offer->description = $request->description;
        $offer->sale_text = $request->sale_text;
        $offer->benefits = $request->benefits ?? null;
        if($request->file('featured_image')){
            $file= $request->file('featured_image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/featured_images'), $filename);
            $offer->featured_image = env('APP_URL') . '/featured_images/' . str_replace(' ', '%20', $filename);
        }
        $benefitsArray = $request->benefits;
        if($benefitsArray){
            foreach($benefitsArray as $language => $benefits){
                foreach($benefits as $key => $benefit) {
                    if(isset($benefit['icon']) && $benefit['icon']){
                        $file= $benefit['icon'];
                        $benefitsArray[$language][$key]['icon'] = $file;
                    }
                }
            }
            
            $offer->benefits = $benefitsArray;
        }
        $offer->company_id = $request->company_id;
        $offer->category_id = Company::find($request->company_id)->category_id;
        $offer->active = $request->status;
        $offer->save();
        
        return redirect()->route('offers')->with('success','Offer Created.');
    }
    
    /**
     * Company Update Method
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $offer->name = $request->name;
        $offer->subtitle = $request->subtitle;
        $offer->description = $request->description;
        $offer->sale_text = $request->sale_text;
        $offer->benefits = $request->benefits ?? null;
        if($request->file('featured_image')){
            $file= $request->file('featured_image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/featured_images'), $filename);
            $offer->featured_image = env('APP_URL') . '/featured_images/' . str_replace(' ', '%20', $filename);
        }
        $benefitsArray = $request->benefits;
       
        if($benefitsArray){
            foreach($benefitsArray as $language => $benefits){
                $benefitsArray[$language] = array_values($benefitsArray[$language]);
                foreach($benefits as $key => $benefit) {
                    if(isset($benefit['icon']) && $benefit['icon']){
                        $benefitsArray[$language][$key]['icon'] = $benefit['icon'];
                    }
                    if(isset($benefit['color']) && $benefit['color']){
                        $benefitsArray[$language][$key]['color'] = $benefit['color'];
                    }
                    if(isset($benefit['url']) && $benefit['url']){
                        $benefitsArray[$language][$key]['url'] = $benefit['url'];
                    }

                }
            }
            
            $offer->benefits = $benefitsArray;
            
        }
        $offer->company_id = $request->company_id ? $request->company_id : $offer->company_id;
        $offer->category_id = Company::find($request->company_id)->category_id;
        $offer->active = $request->status;
        $offer->save();
        return redirect()->route('offers')->with('success','Offer Updated.');
    }
    
    /**
     * Company Delete Method
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function destroy($id)
    {
        $offer = Offer::FindOrFail($id);
        $offer->delete();
        return redirect()->route('offers')->with('success','Offer Deleted.');
        
    }
}
