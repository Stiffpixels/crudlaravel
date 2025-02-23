<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Middleware\OnlyAdmin;
use App\Http\Middleware\JwtExists;

Route::get('/', function () {
    return view('welcome');
});

//auth
Route::middleware([JwtExists::class])->group(function(){
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, "login"]);
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, "register"]);
});

Route::middleware([JwtMiddleware::class])->group(function(){

    Route::prefix('dashboard')->group(function(){
        Route::View('', 'admin.dashboard')->name("dashboard");

        Route::middleware([OnlyAdmin::class])->group(function(){
            //user crud
            Route::post('/users/add', [UserController::class, 'addUser'])->name("users.add");
            Route::get('/users', [UserController::class, 'getAllUsers'])->name("users");
            Route::post('/users/update/{id}', [UserController::class, 'updateUser']);
            Route::get('/users/delete/{id}', [UserController::class, 'deleteUser']);
        });

        //category crud
        Route::post('/categories/add', [CategoryController::class, 'addCategory'])->name("categories.add");
        Route::get('/categories', [CategoryController::class, 'getAllCategories'])->name("categories");
        Route::post('/categories/update/{id}', [CategoryController::class, 'updateCategory']);
        Route::get('/categories/delete/{id}', [CategoryController::class, 'deleteCategory']);

        //products crud
        Route::post('/products/add', [ProductController::class, 'addProduct'])->name("products.add");

        //product datatable view
        Route::get('/products', [ProductController::class, 'displayDataTable'])->name("products");

        //product datatable json data for ajax
        Route::get('/products/datatable', [ProductController::class, 'getDataTable'])->name("products.datatable");

        Route::post('/products/update/{id}', [ProductController::class, 'updateProduct']);
        Route::get('/products/delete/{id}', [ProductController::class, 'deleteProduct']);
    });

    Route::get('/logout', [AuthController::class, "logout"]);
});
