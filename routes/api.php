<?php

use App\Http\Controllers\WaqfController;
use App\Http\Middleware\CustomAuthenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware([CustomAuthenticate::class])->group(function () {
    Route::post('/waqf',[WaqfController::class,'createWaqf']);
    Route::get('/awqaf',[WaqfController::class,'awqafByUser']);
    Route::put('/waqf/{id}',[WaqfController::class,'updateWaqf']);
    Route::delete('/waqf/{id}',[WaqfController::class,'deleteWaqf']);
    });