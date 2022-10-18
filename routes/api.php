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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [App\Http\Controllers\API\LoginController::class, 'login']);
Route::prefix('user')->middleware('UserAuth')->group(function () {
    Route::get('/me', [App\Http\Controllers\API\LoginController::class, 'me']);
    Route::get('list', [App\Http\Controllers\API\User\LawyerController::class, 'list']);
    Route::get('type_of_lawyers', [App\Http\Controllers\API\User\LawyerController::class, 'list']);
    Route::post('reserve', [App\Http\Controllers\API\User\LawyerController::class, 'reserve']);
});
Route::prefix('lawyer')->middleware('UserAuth')->group(function () {
    Route::middleware('LawyerAuth')->middleware('LawyerEnabled')->group(function () {
        Route::get('/me', [LawyerAuthController::class, 'me']);
        Route::post('/complete_profile', [LawyerAuthController::class, 'complete_profile']);
        Route::post('add_workings_hours', [AppointmentController::class, 'add_workings_hours']);
        Route::post('delete_workings_hours', [AppointmentController::class, 'delete_workings_hours']);
        Route::get('get_workings_hours', [AppointmentController::class, 'get_workings_hours']);
        Route::get('my_reservations', [AppointmentController::class, 'my_reservations']);
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
Route::get('test', function () {

});
