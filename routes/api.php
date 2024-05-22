<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\Auth\CodeCheckController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::get('/welcome/{lang}', [HomeController::class, 'welcome']);

Route::middleware(['checkUserStatus', 'auth:sanctum'])->group(function () {
    Route::get('/cards', [HomeController::class, 'cards'])->middleware('auth:sanctum');
    Route::get('/card', [HomeController::class, 'card'])->middleware('auth:sanctum');
    Route::get('/homepage/{lang}', [HomeController::class, 'homepage'])->middleware('auth:sanctum');
    Route::get('/offers/{lang}', [HomeController::class, 'offers'])->middleware('auth:sanctum');
    Route::get('/offer/{lang}/{id}', [HomeController::class, 'getOffer'])->middleware('auth:sanctum');
    Route::get('/favorites/{lang}', [HomeController::class, 'favorites'])->middleware('auth:sanctum');
    Route::post('/favorite/{id}', [HomeController::class, 'favorite'])->middleware('auth:sanctum');
    Route::get('/categories/{lang}', [HomeController::class, 'categories'])->middleware('auth:sanctum');
    Route::post('/attachCard/{id}', [HomeController::class, 'attachCard'])->middleware('auth:sanctum');
    Route::get('/currentUser', [HomeController::class, 'currentUser']);
    Route::post('/editPassword', [HomeController::class, 'edit_password'])->middleware('auth:sanctum');
    Route::get('/notifications/{lang}', [NotificationController::class, 'index'])->middleware('auth:sanctum');
    Route::get('/notification/{id}', [NotificationController::class, 'mark_as_read'])->middleware('auth:sanctum');
    Route::get('/unread-notifications/{lang}', [NotificationController::class, 'unread_notifications'])->middleware('auth:sanctum');
    
    Route::get('/device-token/add', [NotificationController::class, 'token_add'])->middleware('auth:sanctum');
    Route::get('/device-token/delete', [NotificationController::class, 'token_delete'])->middleware('auth:sanctum');
});
 // Password reset routes
Route::post('password/email',  ForgotPasswordController::class);
Route::post('password/code/check', CodeCheckController::class);
Route::post('password/reset', ResetPasswordController::class);

Route::post('/wp/register', [AuthController::class, 'wp_create_user']);
Route::post('/wp/sync', [AuthController::class, 'wp_sync_user']);
Route::post('/wp/check/email', [AuthController::class, 'check_email']);
Route::get('/wp/check/email', [AuthController::class, 'check_email']);
Route::post('/wp/password', [AuthController::class, 'wp_sync_password']);
