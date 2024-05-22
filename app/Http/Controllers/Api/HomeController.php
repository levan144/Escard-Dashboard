<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Setting;
use App\Models\Offer;
use App\Models\Category;
use Maize\Markable\Models\Like;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Hash;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    
    public function welcome($lang = 'ka') {
        $welcome_screens = json_decode(Setting::where('title', 'welcome_screens')->where('language', $lang)->first()->value, true);
        $logo = Setting::where('title', 'logo')->first()->value;
        $welcome_illustration = Setting::where('title', 'welcome_illustration')->first()->value;
        $data = array('images' => array('logo' => $logo, 'illustration' => $welcome_illustration), 'pages' => $welcome_screens);
        return response()->json([
                'status' => true,
                'message' => 'Data is displayed',
                'data' => $data,
            ], 200);
    }
    
    public function card() {
        $user = auth('sanctum')->user();
        $card = $user->getCard;
        $barcode = $logo = Setting::where('title', 'barcode')->first()->value;
        return response()->json([
                'status' => true,
                'message' => 'Card are displayed',
                'data' => ['card' => $card, 'barcode' => $barcode],
            ], 200);
    }
    
    public function cards() {
        $cards = Card::all();
        return response()->json([
                'status' => true,
                'message' => 'Cards are displayed',
                'data' => $cards,
            ], 200);
    }
    
    public function homepage($lang = 'ka') {
        $homepage_screens = json_decode(Setting::where('title', 'homepage')->first()->value ?? '{}', true);
        $general_slider = [];
        foreach(array_slice($homepage_screens['general_slider'], 0,10 ) as $slide) {
            $offer = Offer::active()->with('getCompany','getCategory')->find($slide);
            if($offer && $offer->active && $offer->getCompany->active){
                $offer = $offer->toArray();
                $offer['name'] = $offer['name'][$lang];
                $offer['subtitle'] = $offer['subtitle'][$lang] ?? null;
                $offer['description'] = $offer['description'][$lang] ?? '';
                $offer['sale_text'] = $offer['sale_text'][$lang] ?? '';
                $offer['get_company']['name'] = $offer['get_company']['name'][$lang];
                $offer['get_category']['name'] = $offer['get_category']['name'][$lang];
                $offer['benefits'] = $offer['benefits'][$lang];
                if(isset($offer['get_company']['working_hours']) && $offer['get_company']['working_hours']){
                    
                    $offer['get_company']['working_hours'] = $offer['get_company']['working_hours'][$lang] ?? null;
                }
                if(isset($offer['get_company']['address']) && $offer['get_company']['address']){
                    $offer['get_company']['address'] = $offer['get_company']['address'][$lang] ?? null;
                }
                $general_slider[] = $offer;
            }
        }
        
        $popular_offers = [];
        foreach(array_slice($homepage_screens['popular_offers'], 0,10 ) as $slide) {
            $offer = Offer::active()->with('getCompany','getCategory')->find($slide);
            if($offer && $offer->active && $offer->getCompany->active){
                $offer = $offer->toArray();
                $offer['name'] = $offer['name'][$lang];
                $offer['subtitle'] = $offer['subtitle'][$lang] ?? null;
                $offer['description'] = $offer['description'][$lang] ?? '';
                $offer['sale_text'] = $offer['sale_text'][$lang] ?? '';
                $offer['get_company']['name'] = $offer['get_company']['name'][$lang];
                $offer['get_category']['name'] = $offer['get_category']['name'][$lang];
                $offer['benefits'] = $offer['benefits'][$lang];
                if(isset($offer['get_company']['working_hours']) && $offer['get_company']['working_hours']){
                    $offer['get_company']['working_hours'] = $offer['get_company']['working_hours'][$lang] ?? null;
                }
                if(isset($offer['get_company']['address']) && $offer['get_company']['address']){
                    $offer['get_company']['address'] = $offer['get_company']['address'][$lang] ?? null;
                }
                $popular_offers[] = $offer;
            }
        }
        
        $bigsale_offers = [];
        foreach(array_slice($homepage_screens['bigsale_offers'], 0,10 ) as $slide) {
            $offer = Offer::active()->with('getCompany','getCategory')->limit(10)->find($slide);
            if($offer && $offer->active && $offer->getCompany->active){
                $offer = $offer->toArray();
                $offer['name'] = $offer['name'][$lang];
                $offer['subtitle'] = $offer['subtitle'][$lang] ?? null;
                $offer['description'] = $offer['description'][$lang]  ?? '';
                $offer['sale_text'] = $offer['sale_text'][$lang] ?? '';
                $offer['get_company']['name'] = $offer['get_company']['name'][$lang];
                $offer['get_category']['name'] = $offer['get_category']['name'][$lang];
                $offer['benefits'] = $offer['benefits'][$lang];
                if(isset($offer['get_company']['working_hours']) && $offer['get_company']['working_hours']){
                    $offer['get_company']['working_hours'] = $offer['get_company']['working_hours'][$lang] ?? null;
                }
                if(isset($offer['get_company']['address']) && $offer['get_company']['address']){
                    $offer['get_company']['address'] = $offer['get_company']['address'][$lang] ?? null;
                }
                $bigsale_offers[] = $offer;
            }
        }
        
        $special_offers = [];
        foreach(array_slice($homepage_screens['special_offers'], 0,10 ) as $slide) {
            $offer = Offer::active()->with('getCompany','getCategory')->limit(10)->find($slide);
            if($offer && $offer->active && $offer->getCompany->active){
                $offer = $offer->toArray();
                $offer['name'] = $offer['name'][$lang];
                $offer['subtitle'] = $offer['subtitle'][$lang] ?? null;
                $offer['description'] = $offer['description'][$lang] ?? '';
                $offer['sale_text'] = $offer['sale_text'][$lang] ?? '';
                $offer['get_company']['name'] = $offer['get_company']['name'][$lang];
                $offer['get_category']['name'] = $offer['get_category']['name'][$lang];
                $offer['benefits'] = $offer['benefits'][$lang];
                if(isset($offer['get_company']['working_hours']) && $offer['get_company']['working_hours']){
                    $offer['get_company']['working_hours'] = $offer['get_company']['working_hours'][$lang] ?? null;
                }
                if(isset($offer['get_company']['address']) && $offer['get_company']['address']){
                    $offer['get_company']['address'] = $offer['get_company']['address'][$lang] ?? null;
                }
                $special_offers[] = $offer;
            }
        }
        
        $favorites = Offer::active()->with('getCategory', 'getCompany')->whereHasLike(
            auth('sanctum')->user()
        )->get();
        $favorites = array_slice($favorites->toArray(),0,10);
        foreach($favorites as $key => $offer) {
            $offer['name'] = $offer['name'][$lang];
            $offer['subtitle'] = $offer['subtitle'][$lang] ?? null;
            $offer['description'] = $offer['description'][$lang] ?? '';
            $offer['sale_text'] = $offer['sale_text'][$lang] ?? '';
            $offer['get_company']['name'] = $offer['get_company']['name'][$lang];
            $offer['get_category']['name'] = $offer['get_category']['name'][$lang];
            $offer['benefits'] = $offer['benefits'][$lang];
            if(isset($offer['get_company']['working_hours']) && $offer['get_company']['working_hours']){
                $offer['get_company']['working_hours'] = $offer['get_company']['working_hours'][$lang] ?? null;
            }
            if(isset($offer['get_company']['address']) && $offer['get_company']['address']){
                $offer['get_company']['address'] = $offer['get_company']['address'][$lang] ?? null;
            }
            $favorites[$key] = $offer;
        }
        $data = ['general_slider' => $general_slider, 'popular_offers' => $popular_offers, 'bigsale_offers' => $bigsale_offers, 'special_offers' => $special_offers, 'favorites' => $favorites];
        return response()->json([
                'status' => true,
                'message' => 'Data is displayed',
                'data' => $data,
            ], 200);
    }
    
    public function favorites(Request $request, $lang = 'ka'){
        $page = $request->has('page') && is_numeric($request->page) ? intval($request->page) : 1;
        $perPage = $request->has('perPage') && is_numeric($request->perPage) ? intval($request->perPage) : 15;
        // $offers = Offer::active()->with('getCategory', 'getCompany')->whereHasLike(
        //     auth('sanctum')->user()
        // )->paginate($perPage, $columns = ['*'] , $page);
        
        $offers = Search::add(Offer::active()->with('getCompany', 'getCategory')->whereHasLike(auth('sanctum')->user()))
                    ->beginWithWildcard()
                    ->orderByRelevance()
                    
                    ->paginate($perPage, $pageName = 'page', $page)
                    ->search();
        
        $offers = $offers->toArray();
        unset($offers['prev_page_url'], $offers['next_page_url'], $offers['path'], $offers['last_page_url'], $offers['first_page_url'], $offers['links'], $offers['to'], $offers['from']);
        foreach($offers['data'] as $key => $offer){
            $offer['name'] = $offer['name'][$lang];
            $offer['subtitle'] = $offer['subtitle'][$lang] ?? null;
            $offer['description'] = $offer['description'][$lang] ?? '';
            $offer['sale_text'] = $offer['sale_text'][$lang] ?? '';
            $offer['get_company']['name'] = $offer['get_company']['name'][$lang];
            $offer['get_category']['name'] = $offer['get_category']['name'][$lang];
            if(isset($offer['get_company']['working_hours']) && $offer['get_company']['working_hours']){
                $offer['get_company']['working_hours'] = $offer['get_company']['working_hours'][$lang] ?? null;
            }
            if(isset($offer['get_company']['address']) && $offer['get_company']['address']){
                $offer['get_company']['address'] = $offer['get_company']['address'][$lang] ?? null;
            }
            $offers['data'][$key] = $offer;
        }
        return response()->json($offers, 200);
    }
    
    
    //Action To Make Favorited or Remove mark
    public function favorite($id){
        $offer = Offer::active()->with('getCategory', 'getCompany')->findOrFail($id);
        Like::toggle($offer, auth('sanctum')->user());
        return response()->json([
                'status' => true,
                'message' => 'Mark status Changed',
            ], 200);
    }
    
   
    
    public function offers(Request $request, $lang = 'ka') {
        
        $phrase = $request->keywords  ?? null;
        $category = $request->category_id;
        $page = intval($request->page ?? 1) ;
        $perPage = intval($request->perPage ?? 15) ;
        if($category) {
            $results = Search::add(Offer::active()->with('getCompany', 'getCategory')->where('category_id', $category), ['name->ka', 'subtitle->en'])->orderBy('sale_text')->orderByDesc()->beginWithWildcard()->paginate($perPage, $pageName = 'page', $page)
                    ->search($phrase);
        } elseif($phrase) {
            $results = Search::add(Offer::active()->with('getCompany', 'getCategory'), ['name->ka', 'subtitle->en'])
                                ->orderBy('sale_text')->beginWithWildcard()->orderByDesc()
                    ->beginWithWildcard()
                    // ->orderByRelevance()
                    ->paginate($perPage, $pageName = 'page', $page)
                    ->search($phrase);
        } else {
            $results = Search::add(Offer::active()->with('getCompany', 'getCategory'))->beginWithWildcard()->orderBy('sale_text')->orderByDesc()
                ->paginate($perPage, $pageName = 'page', $page)->search();
        }
        $results = $results->toArray();
        foreach($results['data'] as $key => $offer){
            $offer['name'] = $offer['name'][$lang];
            $offer['subtitle'] = $offer['subtitle'][$lang] ?? null;
            $offer['description'] = $offer['description'][$lang] ?? '';
            $offer['sale_text'] = $offer['sale_text'][$lang] ?? '';
            $offer['benefits'] = $offer['benefits'][$lang] ?? null;
            $offer['get_category']['name'] = $offer['get_category']['name'][$lang];
            if(isset($offer['get_company'])){
                $offer['get_company']['name'] = $offer['get_company']['name'][$lang] ?? null;
                if(isset($offer['get_company']['working_hours']) && $offer['get_company']['working_hours']){
                    $offer['get_company']['working_hours'] = $offer['get_company']['working_hours'][$lang] ?? null;
                }
                if(isset($offer['get_company']['address']) && $offer['get_company']['address']){
                    $offer['get_company']['address'] = $offer['get_company']['address'][$lang] ?? null;
                }
            }
            $results['data'][$key] = $offer;
        }
        
        
        
        unset($results['prev_page_url'], $results['next_page_url'], $results['path'], $results['last_page_url'], $results['first_page_url'], $results['links'], $results['to'], $results['from']);
        return response()->json($results, 200);
    }
    
    public function getOffer( $lang = 'ka',$id){
        $offer = Offer::with('getCompany','getCategory')->findOrFail($id);
        
        $offer->get_benefits = array();
        
        $offer->get_benefits = array(
            array('icon' => 'https://dashboard.escard.ge/icons/202301031337icon-diamond.png', 'title' => 'ფასდაკლება', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting...', 'promo_code' => null),
            array('icon' => 'https://dashboard.escard.ge/icons/202301031337icon-diamond.png', 'title' => 'პრომო კოდი', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting...', 'promo_code' => 'Qwqweq'),
            array('icon' => 'https://dashboard.escard.ge/icons/202301031337icon-diamond.png', 'title' => 'სპეციალური შეთავაზება', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting...', 'promo_code' => null),
            );
        // $offer->get_benefits[] = ['icon' => 'url', 'title' => 'ფასდაკლება', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting...', 'promo_code' => 'Qwqweq'];
        // $offer->get_benefits[] = ['icon' => 'url', 'title' => 'ფასდაკლება', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting...', 'promo_code' => 'Qwqweq'];
            $offer = $offer->toArray();
            $offer['name'] = $offer['name'][$lang];
            $offer['subtitle'] = $offer['subtitle'][$lang] ?? null;
            $offer['description'] = $offer['description'][$lang] ?? '';
            $offer['sale_text'] = $offer['sale_text'][$lang] ?? '';
            $offer['get_benefits'] = $offer['benefits'][$lang] ?? null;
            $offer['get_company']['name'] = $offer['get_company']['name'][$lang] ?? null;
            $offer['get_category']['name'] = $offer['get_category']['name'][$lang] ?? null;
            unset($offer['benefits']);
            if(isset($offer['get_company']['working_hours']) && $offer['get_company']['working_hours']){
                $offer['get_company']['working_hours'] = $offer['get_company']['working_hours'][$lang] ?? null;
            }
            if(isset($offer['get_company']['address']) && $offer['get_company']['address']){
                $offer['get_company']['address'] = $offer['get_company']['address'][$lang] ?? null;
            }
        return response()->json([
                'status' => true,
                'message' => 'Data is displayed',
                'data' => $offer,
            ], 200);
            
    }
    
    public function categories($lang = 'ka') {
        $categories = Category::all();
        $data = $categories;
        // $categories = $categories->toArray();
        foreach($data as $key => $category) {
            $category = $category->toArray();
            $category['name'] = $category['name'][$lang] ?? null;
            $category['icon'] = $category['icon'] ?? null;
            $category['icon_hover'] = $category['icon_hover'] ?? null;
            $data[$key] = $category;
        }
       
        return response()->json([
                'status' => true,
                'message' => 'Data is displayed',
                'data' => $data,
            ], 200);
    }
    
    public function attachCard($id) {
        if(Card::find($id)){
            $user = auth('sanctum')->user();
            $user->card_id = $id;
            $user->save();
            return response()->json([
                'status' => true,
                'message' => 'Card Attached Successfully',
            ], 200);
        }
        
        return response()->json([
                'status' => false,
                'message' => 'Card not found',
            ], 401);
        
    }
    
    public function currentUser() {
        $user = auth('sanctum')->user()->load(['getCompany', 'getCard']);
        
        return response()->json([
                'status' => true,
                'data' => $user,
            ], 200);
    }
    
    public function edit_password(Request $request){
        
        if($request->password && $request->password === $request->confirm_password){
            $user = auth('sanctum')->user();
            $user->password = Hash::make($request->password);
            $user->save();
            
            return response()->json([
                'status' => true,
                'message' => 'Password Updated Successfully',
            ], 200);
        } else {
            return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                ], 401);
        }
        
    }
}
