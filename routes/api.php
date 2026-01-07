<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/client', [ClientController::class, 'create_client']);
Route::get('/client',[ClientController::class,'index']);
Route::patch('/client/{id}',[ClientController::class,'update_client']);
Route::delete('/client/{id}',[ClientController::class,'delete_client']);


Route::post('/category', [CategoryController::class, 'create_category']);
Route::get('/category', [CategoryController::class, 'index']);
Route::patch('/category/{id}', [CategoryController::class, 'update_category']);
Route::delete('/category/{id}', [CategoryController::class, 'delete_category']);

// Route::get('/categories',[ApiController::class,'categories']);
// Route::get('/category/{slug}',[ApiController::class,'category']);
