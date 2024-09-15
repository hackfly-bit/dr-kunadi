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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::prefix('auth')->group(function () {
// Suggested code may be subject to a license. Learn more: ~LicenseLog:3056634965.
Route::post('/register', [AuthController::class, 'register']);  
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
// });

// Route Keluarga
Route::resource('keluarga', KeluargaController::class)->middleware('auth:sanctum');  
Route::resource('rekam-medis', RekamMedisController::class)->middleware('auth::sanctum');
Route::resource('daily-log', DailyLogController::class )->middleware('auth:sanctum');
Route::resource('monthly-log', MonthlyLogModelController::class)->middleware('auth:sanctum');
Route::resource('nutrition-log', NutritionLogController::class)->middleware('auth:sanctum');
Route::resource('nutrition-log-setting', NutritionLogSettingController::class)->middleware('auth:sanctum');