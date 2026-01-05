<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CustomerController;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories',[ApiController::class,'categories']);
