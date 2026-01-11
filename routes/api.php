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
    Route::get('/client',[ClientController::class,'index']);
    Route::patch('/client/{id}',[ClientController::class,'update_client']);
    Route::delete('/client/{id}',[ClientController::class,'delete_client']);

    Route::post('/category', [CategoryController::class, 'create_category']);
    Route::get('/category', [CategoryController::class, 'index']);
    Route::patch('/category/{id}', [CategoryController::class, 'update_category']);
    Route::delete('/category/{id}', [CategoryController::class, 'delete_category']);

    Route::post('/order', [OrderController::class, 'create_order']);
    Route::get('/order', [OrderController::class, 'index']);
    Route::patch('/order/{id}', [OrderController::class, 'update_order']);
    Route::delete('/order/{id}', [OrderController::class, 'delete_order']);

    Route::post('/product',[ProductController::class,'create_product']);
    Route::get('/product',[ProductController::class,'index']);
    Route::patch('/product/{id}',[ProductController::class,'update_product']);
    Route::delete('/product/{id}',[ProductController::class,'delete_product']);

    Route::post('/payment', [PaymentController::class, 'process_payment']);
    Route::get('/payment', [PaymentController::class, 'index']);
    Route::patch('/payment/{id}', [PaymentController::class, 'edit_payment']);
    Route::delete('/payment/{id}', [PaymentController::class, 'delete_payment']);

    Route::post('/cart', [CartController::class, 'add_to_cart']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::patch('/cart/{id}', [CartController::class, 'update_cart']);
    Route::delete('/cart/{id}', [CartController::class, 'delete_cart']);

    });

Route::post('/logout', [AuthController::class, 'logout_user']);
Route::post('/user', [AuthController::class, 'register_user']);
Route::post('/login', [AuthController::class, 'login_user']);
