<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Category;
use App\Models\DeviceToken;
use App\Models\Offer;
use App\Models\Notification;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Imports\MessageUsersImport;
use GuzzleHttp\Client;

class NotificationController extends Controller
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
        $notifications = Notification::all();
        
        return view('messages.index', compact('notifications'));
    }
    
    /**
     * Show the Company create form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $users = User::all();
        $companies = Company::all();
        $offers = Offer::all();
        return view('messages.create', compact('users', 'companies','offers'));
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
        $company_id = $request->company_id;
        if($company_id !== '-1' && $company_id) {
            $company = Company::find($request->company_id);
            $users = $company->getUsers;
        } else {
            $users = $company_id ? User::all() : null;
        }
        
        $data = [];
        $data['title'] = $request->title;
        $data['subtitle'] = $request->subtitle;
        $data['description'] = $request->description;
        
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/thumbnails'), $filename);
            $data['thumbnail'] = env('APP_URL') . '/thumbnails/' . str_replace(' ', '%20', $filename);
        }
        if($request->send_to !== '0') {
            $excel = Excel::toArray(new MessageUsersImport, $request->custom_list)[0];
            foreach($excel as $user){
                $user = User::where('email', $user['email'])->firstOrFail();
                $data['promo_code'] = $user['promo'];
                $data['offer_id'] = $user['offer_id'];
                
                $type = $data['promo_code'] ? 'App\Notications\Promocode' : 'App\Notications\Message';
                $notification = new Notification;
                // dd(Notification::all()->last());
                $notification->id = (Notification::all()->last()->id ?? 0) + 1;
                $notification->type = $type;
                $notification->notifiable_type = 'App\Models\User';
                $notification->notifiable_id = $user->id;
                $data['id'] = $notification->id;
                $notification->data = $data;
                $notification->save();
                $sent = $this->sendToFirebase($notification, $user->id);
            }
        } else {
            $data['promo_code'] = $request->promocode ?? null;
            $data['offer_id'] = $request->offer_id ?? null;
            $type = $data['promo_code'] ? 'App\Notications\Promocode' : 'App\Notications\Message';
            foreach($users as $user) {
                $notification = new Notification;
                $notification->id = (Notification::all()->last()->id ?? 0) + 1;
                $notification->type = $type;
                $notification->notifiable_type = 'App\Models\User';
                $notification->notifiable_id = $user->id;
                $data['id'] = $notification->id;
                $notification->data = $data;
                $notification->save();
                $sent = $this->sendToFirebase($notification, $user->id);
            }
        }
        
        
        
        return redirect()->route('messages.new')->with('success','Message Sent.');
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
        
        if($request->file('thumbnail')){
            $file= $request->file('thumbnail');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('/featured_images'), $filename);
            // $company->featured_image = env('APP_URL') . '/featured_images/' . str_replace(' ', '%20', $filename);
        }
        $company->active = $request->status;
        $company->save();
        
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
    
    public function sendToFirebase($notify, $user_id) {
        // Define the FCM API endpoint and your FCM server key
        $apiEndpoint = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAASBK9Gec:APA91bFR1AIQM7vqxozzQKZf-txVJwhd0YUYc4Beqxx1wqrCHwtDheXvtAGIJabpL6M970tnOLZvUPNxdqfBAhhhjMlMwgcQpb9oKUSYuFfKMdCQiFC6d5q3mjGeTQVYGwzVs7xS9GLJ';
        
        // Define the recipient device token and the notification payload
        $deviceToken = DeviceToken::where('user_id', $user_id)->first()->token ?? null;
        
        if(!$deviceToken){
            return null;
        }
        $notification = [
            'title' => $notify->getTranslations('data')['title']['ka'],
            'body' => $notify->getTranslations('data')['subtitle']['ka'],
        ];
        $data = [
            'senderId' => '309552028135',
            'messageId' => $notify->id,
        ];
        
        // Construct the FCM API request
        $client = new Client();
        $response = $client->request('POST', $apiEndpoint, [
            'headers' => [
                'Authorization' => 'key='.$serverKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $deviceToken,
                'notification' => $notification,
                'data' => $data,
            ],
        ]);
        
        // Handle the response
        if ($response->getStatusCode() === 200) {
            $responseBody = json_decode($response->getBody(), true);
            return $responseBody;
            // Handle success
        } else {
            return $response->getStatusCode();
        }
    }
}