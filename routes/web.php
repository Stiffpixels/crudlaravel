<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\JwtExists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([JwtExists::class])->group(function(){
    Route::get('/login', [AuthController::class, "createLogin"])->name('login');
    Route::post('/login', [AuthController::class, "storeLogin"]);
    Route::get('/register', [AuthController::class, "create"])->name('register');
    Route::post('/register', [AuthController::class, "store"]);
});

Route::middleware([JwtMiddleware::class])->group(function(){
    Route::View('/dashboard', 'admin.dashboard')->name("dashboard");
    Route::get('/dashboard/users', [UserController::class, 'index'])->name("users");
    Route::get('/dashboard/categories', [CategoryController::class, 'index'])->name("categories");
    Route::get('/logout', [AuthController::class, "logout"]);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
