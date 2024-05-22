<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/401', function () {
    return response()->json([
                'code' => 401,
                'message' => 'Login information is invalid.'
              ], 401);
})->name('401');
Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);

Route::middleware(['auth', 'admin_role'])->group(function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');
Route::get('/home/{lang}/settings', [App\Http\Controllers\HomeController::class, 'settings_lang'])->name('settings.single');

Route::post('/home/settings/update/{lang}', [App\Http\Controllers\HomeController::class, 'update'])->name('settings.update');

Route::get('/home/companies', [App\Http\Controllers\CompanyController::class, 'index'])->name('companies');
Route::get('/home/companies/new', [App\Http\Controllers\CompanyController::class, 'create'])->name('companies.new');
Route::get('/home/companies/edit/{id}', [App\Http\Controllers\CompanyController::class, 'edit'])->name('companies.edit');
Route::post('/home/companies/store', [App\Http\Controllers\CompanyController::class, 'store'])->name('companies.store');
Route::post('/home/companies/update/{id}', [App\Http\Controllers\CompanyController::class, 'update'])->name('companies.update');
Route::get('/home/companies/delete/{id}', [App\Http\Controllers\CompanyController::class, 'destroy'])->name('companies.delete');
Route::get('/home/companies/pause/{id}', [App\Http\Controllers\CompanyController::class, 'pause'])->name('companies.pause');
Route::get('/home/companies/enable/{id}', [App\Http\Controllers\CompanyController::class, 'enable'])->name('companies.enable');

Route::get('/home/offers', [App\Http\Controllers\OfferController::class, 'index'])->name('offers');
Route::get('/home/offers/new', [App\Http\Controllers\OfferController::class, 'create'])->name('offers.new');
Route::get('/home/offers/edit/{id}', [App\Http\Controllers\OfferController::class, 'edit'])->name('offers.edit');
Route::post('/home/offers/store', [App\Http\Controllers\OfferController::class, 'store'])->name('offers.store');
Route::post('/home/offers/update/{id}', [App\Http\Controllers\OfferController::class, 'update'])->name('offers.update');
Route::get('/home/offers/delete/{id}', [App\Http\Controllers\OfferController::class, 'destroy'])->name('offers.delete');


Route::get('/home/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::post('/home/categories/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
Route::get('/home/categories/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
Route::post('/home/categories/update/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
Route::get('/home/categories/delete/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.delete');

Route::get('/home/cards', [App\Http\Controllers\CardController::class, 'index'])->name('cards');
Route::post('/home/cards/store', [App\Http\Controllers\CardController::class, 'store'])->name('cards.store');
Route::get('/home/cards/edit/{id}', [App\Http\Controllers\CardController::class, 'edit'])->name('cards.edit');
Route::post('/home/cards/update/{id}', [App\Http\Controllers\CardController::class, 'update'])->name('cards.update');

Route::get('/home/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::get('/home/users/new', [App\Http\Controllers\UserController::class, 'create'])->name('users.new');
Route::get('/home/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::post('/home/users/store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
Route::post('/home/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
Route::get('/home/users/delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
Route::post('/home/users/import', [App\Http\Controllers\UserController::class, 'import'])->name('users.import');
Route::get('/home/users/enable/{id}', [App\Http\Controllers\UserController::class, 'enable'])->name('users.enable');
Route::get('/home/deleted_users', [App\Http\Controllers\UserController::class, 'deleted_users'])->name('deleted_users');
Route::post('/home/users/mass_delete', [App\Http\Controllers\UserController::class, 'massDelete'])->name('users.massDelete');


Route::get('/home/messages', [App\Http\Controllers\NotificationController::class, 'index'])->name('messages');
Route::get('/home/messages/new', [App\Http\Controllers\NotificationController::class, 'create'])->name('messages.new');
Route::post('/home/messages/store', [App\Http\Controllers\NotificationController::class, 'store'])->name('messages.store');

Route::get('/home/user/passwordchange/{id}', [App\Http\Controllers\UserController::class, 'generateUserPassword'])->name('password.generate');
});

Route::get('/testroute', function(){
    $client = new GuzzleHttp\Client();
    
    // $res = $client->request('GET', 'https://rustavi-webmed.aversiclinic.ge/Statistic/TotalVisits', ['auth' => ['4a26d78c-ff15-41fa-87ce-61881c5ce91e', '90446098-e567-4490-8bab-fae4273420ab']]);
    // $res = $client->request('GET', 'https://clinic-webmed.aversiclinic.ge/Patient/SendSmsVerification', ['auth' => ['d01a667f-a60e-4772-9ac4-46d7e378442e', 'ebd6b155-782b-4131-a237-a530da11d5ba']]);
        $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/Services/list', ['headers' => ['Content-Type' => 'application/json'], 'json' => [
        'organizationId' => '581abe35-a12c-489a-75cc-08da212c2926'], 'auth' => ['4511aac9-57ef-4d83-acea-54b8a1a44ae0', 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4']]);
    //  $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/Calendars/getSchedule', ['headers' => ['Content-Type' => 'application/json'], 'json' => [
    //     'organizationSourceId' => '5', 'startDate' => '2023-06-08T06:12:44.359Z', 'endDate' => '2023-06-09T06:12:44.359Z'], 'auth' => ['4511aac9-57ef-4d83-acea-54b8a1a44ae0', 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4']]);
    
    
    // $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/People/list', ['headers' => ['Content-Type' => 'application/json'], 'json' => [
    //     'organizationId' => '581abe35-a12c-489a-75cc-08da212c2926'], 'auth' => ['4511aac9-57ef-4d83-acea-54b8a1a44ae0', 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4']]);
    // foreach(json_decode($res->getBody()) as $doc) {
    //     $doctor = Doctor::where('sid', $doc->personalId)->first();
    //     if($doctor){
    //         $doctor->service_id = $doc->id;
    //         $doctor->save();
    //     }
        
    // }
    // $res = $client->request('POST', 'https://webbooking.aversiclinic.ge/api/Organizations/list', [
    //     'headers' => ['Content-Type' => 'application/json'], 
    //     'auth' => ['4511aac9-57ef-4d83-acea-54b8a1a44ae0', 'b1f3fde2-2139-46a5-b60a-7dcb2256ecc4'],
    //     'json' => [
    //         'organizationId' => '581abe35-a12c-489a-75cc-08da212c2926'],
    //     ]);
    // dd();
    
    // Step 1: Retrieve data from the database
// $databaseData = AppointmentService::all()->toArray(); // Replace YourDatabaseModel with your actual database model

// // Step 2: Make API request to fetch updated data
$apiResponse = $res->getBody(); // Make your API request to fetch the updated data

// // Step 3: Convert API response into an array
$apiData = json_decode($apiResponse, true);
print_r($apiData);
// // Step 4: Iterate over the data from the database and the API response
// foreach ($databaseData as $key => $dbItem) {
//     foreach ($apiData as $apiItem) {
//         // Step 5: Check if the codes match
//         if ($dbItem['code'] === $apiItem['code']) {
//             // Step 6: Update the corresponding entry in the database
//             AppointmentService::where('code', $dbItem['code'])->update([
//                 'service_id' => $apiItem['id'], // Replace column_to_update with the actual column in your database that needs to be updated
//             ]);
//         }
//     }
// }
    
});

