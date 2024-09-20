<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DailyLogController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\MonthlyLogModelController;
use App\Http\Controllers\NutritionLogController;
use App\Http\Controllers\NutritionLogSettingController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\UserDetailController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Auth routes
Route::post('/register', [AuthController::class, 'register']);  
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUserDetail'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Group routes with auth:sanctum middleware
Route::middleware('auth:sanctum')->group(function () {
    // Route Keluarga
    Route::resource('keluarga', KeluargaController::class);  
    Route::resource('rekam-medis', RekamMedisController::class);
    Route::resource('daily-log', DailyLogController::class);
    Route::resource('monthly-log', MonthlyLogModelController::class);
    Route::resource('nutrition-log', NutritionLogController::class);
    Route::resource('nutrition-log-setting', NutritionLogSettingController::class);
    Route::resource('user-detail', UserDetailController::class);
});