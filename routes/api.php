<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
// Suggested code may be subject to a license. Learn more: ~LicenseLog:3056634965.
    Route::post('/register', 'Auth@register');
    Route::post('/login', 'Auth@login');
    Route::post('/logout', 'Auth@logout');
});
