<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware'=> 'auth'], function (){
    Route::get('/home', [UrlController::class, 'index'])->name('home');
    Route::get('/shorten', [UrlController::class, 'create'])->name('url.create');
    Route::post('/shorten', [UrlController::class, 'shorten'])->name('url.shorten');
    Route::delete('/shorten/{id}', [UrlController::class, 'destroy'])->name('url.delete');

    Route::get('/{code}', [UrlController::class, 'redirect'])->name('url.redirect')->where('code', '[A-Za-z0-9]+');
});

Route::get('/{code}', [UrlController::class, 'redirect'])->name('url.redirect')->where('code', '[A-Za-z0-9]+');

