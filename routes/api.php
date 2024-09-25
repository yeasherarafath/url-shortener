<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function(){
    Route::post('login', [ApiController::class,'login']);
    Route::get('logout', [ApiController::class,'logout']);
    Route::post('refresh', [ApiController::class,'refresh']);
    Route::post('me', [ApiController::class,'me']);
});
Route::prefix('url')->middleware('auth:api')->group(function(){
    Route::post('create', [ApiController::class,'storeShortURL']);
});