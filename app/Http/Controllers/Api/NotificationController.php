<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Setting;
use App\Models\Offer;
use App\Models\DeviceToken;
use App\Models\Notification;
use Maize\Markable\Models\Like;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Hash;
use Illuminate\Support\Arr;
use GuzzleHttp\Client;
class NotificationController extends Controller
{
    public function index($lang = 'ka') {
        
        $homepage_screens = json_decode(Setting::where('title', 'homepage')->where('language', $lang)->first()->value ?? '{}', true);
        $special_offers = [];
        foreach($homepage_screens['special_offers'] as $slide) {
            $offer = Offer::active()->with(['getCompany','getCategory'])->find($slide);
            if($offer && $offer->active && $offer->getCompany->active){
                $offer = $offer->toArray();
                $offer['name'] = $offer['name'][$lang];
                $offer['subtitle'] = $offer['subtitle'][$lang] ?? null;
                $offer['description'] = $offer['description'][$lang] ?? null;
                $offer['sale_text'] = $offer['sale_text'][$lang] ?? null;
                $offer['benefits'] = $offer['benefits'][$lang] ?? null;
                $offer['get_company']['name'] = $offer['get_company']['name'][$lang];
               
                $offer['get_category']['name'] = $offer['get_category']['name'][$lang];
                if(isset($offer['get_company']['working_hours']) && $offer['get_company']['working_hours']){
                    $offer['get_company']['working_hours'] = $offer['get_company']['working_hours'][$lang] ?? null;
                }
                if(isset($offer['get_company']['address']) && $offer['get_company']['address']){
                    $offer['get_company']['address'] = $offer['get_company']['address'][$lang] ?? null;
                }
                $special_offers[] = $offer;
            }
        }
        
        $data = [];
        foreach(auth('sanctum')->user()->notifications as $notification) {
            $message = [];
            
            $single = $notification->toArray();
            // $single['data']['id'] = $single['id'];
            $single['data']['title'] = $single['data']['title'][$lang] ?? '';
            $single['data']['subtitle'] = $single['data']['subtitle'][$lang] ?? '';
            $single['data']['description'] = $single['data']['description'][$lang] ?? '';
            $single['data']['promo_code'] = $single['data']['promo_code'] ?? '';
            $message = $single['data'];
            $message['created_at'] = $notification->created_at;
            $message['read_at'] = $notification->read_at;
            $data[] = $message;
        }
        return response()->json([
                'status' => true,
                'message' => 'Data is displayed',
                'notifications' => $data,
                'special_offers' => $special_offers
            ], 200);
    }
    
    public function mark_as_read($id) {
        $notification = Notification::findOrFail($id);
        $notification->read_at = now();
        $notification->save();
        return response()->json([
                'status' => true,
                'message' => 'Notification marked as read',
            ], 200);
    }
    
    public function unread_notifications($lang = 'ka'){
        $notifications = auth()->user('sanctum')->unreadNotifications;
        return response()->json([
                'status' => true,
                'message' => 'Count of unread notifications is displayed',
                'count' => $notifications->count(),
            ], 200);
    }
    
    public function token_add(Request $request){
        $user = auth('sanctum')->user();
        $token = $request->device_token;
        $deviceToken = new DeviceToken;
        $deviceToken->user_id = $user->id;
        $deviceToken->token = $token;
        $deviceToken->save();
        
        return response()->json([
                'status' => true,
                'message' => 'Token added',
            ], 200);
    }
    
    public function token_delete(Request $request){
        $user = auth('sanctum')->user();
        $deviceToken = DeviceToken::where('user_id', $user->id)->firstOrFail();
        $deviceToken->delete();
        return response()->json([
                'status' => true,
                'message' => 'Token deleted',
            ], 200);
    }
    
    public function sendToFirebase($notification, $user_id) {
        // Define the FCM API endpoint and your FCM server key
        $apiEndpoint = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = '<your FCM server key>';
        
        // Define the recipient device token and the notification payload
        $deviceToken = DeviceToken::Find($user_id)->first()->token;
        if(!$deviceToken){
            return false;
        }
        $notification = [
            'title' => 'New message',
            'body' => 'You have a new message from John Doe',
        ];
        $data = [
            'senderId' => '12345',
            'messageId' => '67890',
            'messageText' => 'Hello, how are you?',
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
            $messageId = $responseBody['message_id'];
            // Handle success
        } else {
            // Handle error
        }
    }
}