<?php

use App\Http\Controllers\WaqfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
Route::post('/waqf',[WaqfController::class,'createWaqf']);
Route::get('/awqaf',[WaqfController::class,'awqafByUser']);
Route::put('/waqf/{id}',[WaqfController::class,'updateWaqf']);
Route::delete('/waqf/{id}',[WaqfController::class,'deleteWaqf']);
});