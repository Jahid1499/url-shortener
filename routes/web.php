<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Auth;
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
    return redirect()->route('home');
});



Auth::routes();

Route::get('/products', [ProductController::class, 'index'])->middleware('auth')->name('product.index');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->middleware('auth')->name('product.edit');
Route::get('/products/create', [ProductController::class, 'create'])->middleware(['auth', 'is_admin'])->name('product.create');
Route::post('/products', [ProductController::class, 'store'])->middleware(['auth', 'is_admin'])->name('product.store');
Route::put('/products/{id}', [ProductController::class, 'update'])->middleware(['auth', 'is_admin'])->name('product.update');
Route::delete('/products/{id}/destroy', [ProductController::class, 'destroy'])->middleware(['auth', 'is_admin'])->name('product.destroy');


Route::group(['middleware'=> 'auth'], function (){
    Route::get('/home', [UrlController::class, 'index'])->name('home');
    Route::get('/shorten', [UrlController::class, 'create'])->name('url.create');
    Route::post('/shorten', [UrlController::class, 'shorten'])->name('url.shorten');
    Route::delete('/shorten/{id}', [UrlController::class, 'destroy'])->name('url.delete');

    Route::get('/{code}', [UrlController::class, 'redirect'])->name('url.redirect')->where('code', '[A-Za-z0-9]+');
});



Route::get('/{code}', [UrlController::class, 'redirect'])->name('url.redirect')->where('code', '[A-Za-z0-9]+');
Route::get('/home', [UrlController::class, 'index'])->name('home');

//Route::resource('/products', ProductController::class);

