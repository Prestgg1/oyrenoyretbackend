<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;

 Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
    
});

Route::middleware(['auth:sanctum'])->get("/users", function (Request $request) {
    return User::all();
});
Route::post("auth/login/",[LoginController::class, 'index'])->name('login');
Route::post('auth/register', [RegisterController::class, 'index'])->name('register');
 
