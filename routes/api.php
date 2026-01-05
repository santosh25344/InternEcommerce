<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\CustomerController;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/client', [ClientController::class, 'create']);

Route::get('/categories',[ApiController::class,'categories']);
Route::get('/category/{slug}',[ApiController::class,'category']);
