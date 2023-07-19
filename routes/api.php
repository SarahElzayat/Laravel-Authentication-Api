<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




// Route::middleware('auth:api')->group(function () {
    Route::post('register', [Controller::class, 'register']);
    Route::post('login', [Controller::class, 'login']);
    Route::post('verify-otp', [Controller::class, 'verify_otp']);
    Route::post('logout', [Controller::class, 'logout'])->middleware('auth:api');

// });
