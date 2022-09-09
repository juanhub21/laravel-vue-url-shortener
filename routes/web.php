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
    return view('urlshortener');
});

Route::get('/yt/{any}', [App\Http\Controllers\UrlShortenerController::class, 'handle']);
Route::get('/clicks/{any}', [App\Http\Controllers\UrlShortenerController::class, 'clicks']);

Route::post('/url/shorten', [App\Http\Controllers\UrlShortenerController::class, 'store']);
