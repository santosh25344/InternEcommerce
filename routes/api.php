<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {   //Grouping routes that require authentication

    Route::post('/client', [ClientController::class, 'create_client']);
    Route::get('/client',[ClientController::class,'index'])->middleware('admin');
    Route::patch('/client/{id}',[ClientController::class,'update_client'])->middleware('admin');
    Route::delete('/client/{id}',[ClientController::class,'delete_client'])->middleware('admin');

    Route::post('/category', [CategoryController::class, 'create_category']);
    Route::get('/category', [CategoryController::class, 'index'])->middleware('admin');
    Route::patch('/category/{id}', [CategoryController::class, 'update_category'])->middleware('admin');
    Route::delete('/category/{id}', [CategoryController::class, 'delete_category'])->middleware('admin');

    Route::post('/order', [OrderController::class, 'create_order']);
    Route::get('/order', [OrderController::class, 'index'])->middleware('admin');
    Route::patch('/order/{id}', [OrderController::class, 'update_order'])->middleware('admin');
    Route::delete('/order/{id}', [OrderController::class, 'delete_order'])->middleware('admin');

    Route::post('/product',[ProductController::class,'create_product']);
    Route::get('/product',[ProductController::class,'index'])->middleware('admin');
    Route::patch('/product/{id}',[ProductController::class,'update_product'])->middleware('admin');
    Route::delete('/product/{id}',[ProductController::class,'delete_product'])->middleware('admin');

    Route::post('/payment', [PaymentController::class, 'process_payment']);
    Route::get('/payment', [PaymentController::class, 'index'])->middleware('admin');
    Route::patch('/payment/{id}', [PaymentController::class, 'edit_payment'])->middleware('admin');
    Route::delete('/payment/{id}', [PaymentController::class, 'delete_payment'])->middleware('admin');

    Route::post('/cart', [CartController::class, 'add_to_cart']);
    Route::get('/cart', [CartController::class, 'index'])->middleware('admin');
    Route::patch('/cart/{id}', [CartController::class, 'update_cart'])->middleware('admin');
    Route::delete('/cart/{id}', [CartController::class, 'delete_cart'])->middleware('admin');

    Route::post('/logout', [AuthController::class, 'logout_user']);
    Route::post('/user', [AuthController::class, 'register_user']);
    Route::patch('/user/{id}', [AuthController::class, 'update_user'])->middleware('admin');
    Route::delete('/user/{id}', [AuthController::class, 'delete_user'])->middleware('admin');
    });

Route::post('/login', [AuthController::class, 'login_user']);
