<?php

use App\Http\Controllers\RedirectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth'])->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/store', [App\Http\Controllers\HomeController::class, 'store'])->name('store');
});

Route::get('/{url:short_code}',RedirectionController::class)->name('short.url');