<?php

use App\Http\Controllers\Api\Constant\ConstantsController;

use App\Http\Controllers\Api\Lawyer\AppointmentController;
use App\Http\Controllers\Api\Lawyer\PlansController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\Lawyer\AuthController as LawyerAuthController;
use Paytabscom\Laravel_paytabs\Facades\paypage;

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


Route::post('/login', [App\Http\Controllers\Api\LoginController::class, 'login']);
Route::get('/check_fcm', [App\Http\Controllers\Api\LoginController::class, 'check_fcm']);
Route::post('/generate_reset_password_code', [App\Http\Controllers\Api\LoginController::class, 'generate_reset_password_code']);
Route::post('/reset_password', [App\Http\Controllers\Api\LoginController::class, 'reset_password']);
Route::post('/register', [App\Http\Controllers\Api\LoginController::class, 'register']);
Route::post('social_login', [App\Http\Controllers\Api\LoginController::class, 'social_login']);
Route::prefix('user')->middleware('UserAuth')->group(function () {
    Route::get('/me', [App\Http\Controllers\Api\LoginController::class, 'me']);
    Route::get('list', [App\Http\Controllers\Api\User\LawyerController::class, 'list']);
    Route::get('type_of_lawyers', [App\Http\Controllers\Api\User\LawyerController::class, 'list']);
    Route::get('lawyer_working_hours', [App\Http\Controllers\Api\User\LawyerController::class, 'lawyer_working_hours']);
    Route::middleware('NotGuest')->group(function ($q){
        Route::post('/reserve_appointment', [App\Http\Controllers\Api\User\LawyerController::class, 'reserve_appointment']);
        Route::get('/my_reservation', [App\Http\Controllers\Api\User\LawyerController::class, 'my_reservation']);
        Route::post('/cancel_reservation', [App\Http\Controllers\Api\User\LawyerController::class, 'cancel_reservation']);
        Route::post('/add_review', [App\Http\Controllers\Api\User\LawyerController::class, 'review_reservation']);
        Route::post('/update_profile', [App\Http\Controllers\Api\User\UserController::class, 'update_profile']);
        Route::get('/get_reviews', [App\Http\Controllers\Api\User\UserController::class, 'get_reviews']);
    });

});
Route::prefix('lawyer')->middleware('UserAuth')->group(function () {
    Route::middleware(['LawyerAuth'])->group(function () {
        Route::get('/me', [LawyerAuthController::class, 'me']);
        Route::post('/complete_profile', [LawyerAuthController::class, 'complete_profile']);
        Route::get('my_subscription', [LawyerAuthController::class, 'my_subscription']);
        Route::post('add_workings_hours', [AppointmentController::class, 'add_workings_hours']);

        Route::post('delete_workings_hours', [AppointmentController::class, 'delete_workings_hours']);
        Route::get('get_workings_hours', [AppointmentController::class, 'get_workings_hours']);
        Route::get('my_reservations', [AppointmentController::class, 'my_reservations']);
        Route::post('complete_reservations', [AppointmentController::class, 'complete_reservations']);
        Route::post('cancel_reservations', [AppointmentController::class, 'cancel_reservations']);

    });
    Route::prefix('plans')->group(function () {
        Route::get('list', [PlansController::class, 'list']);
        Route::post('payment', [PlansController::class, 'payment']);
    });
});

Route::prefix('constants')->group(function () {
    Route::get('/cities', [ConstantsController::class, 'cities']);
    Route::get('/lawyer_types', [ConstantsController::class, 'lawyer_types']);
});
Route::post('send_code', [\App\Http\Controllers\Api\LoginController::class, 'send_code']);
Route::get('subscription_lawyers', [App\Http\Controllers\Api\User\LawyerController::class, 'subscription_lawyers']);
Route::get('guest_token', [App\Http\Controllers\Api\LoginController::class, 'guest_login']);
