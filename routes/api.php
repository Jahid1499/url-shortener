<?php

use App\Http\Controllers\Api\UrlController;
use App\Http\Controllers\Api\UserController;
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

Route::post('/auth/login', [UserController::class, 'Login']);
Route::post('/auth/registration', [UserController::class, 'Registration']);

Route::group(['middleware'=> 'tokenVerify'], function (){
    Route::get('/home', [UrlController::class, 'index']);
    Route::post('/shorten', [UrlController::class, 'shorten']);
    Route::delete('/shorten/{id}', [UrlController::class, 'destroy']);

    Route::get('/{code}', [UrlController::class, 'redirect'])->where('code', '[A-Za-z0-9]+');
});

Route::get('/{code}', [UrlController::class, 'redirect'])->where('code', '[A-Za-z0-9]+');
