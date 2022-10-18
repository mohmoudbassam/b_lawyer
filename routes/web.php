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
    $client = new \CMText\TextClient('your-api-key');
});
Route::any('after_payment/{payment_id}', [App\Http\Controllers\PaymentController::class, 'after_payment'])->name('after_payment');
