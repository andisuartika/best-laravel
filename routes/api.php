<?php

use App\Http\Controllers\Api\AccomodationController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\TourController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VillageInfoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user-validation', [UserController::class, 'checkUnique']);


// API Get Info Desa
Route::get('info-village', [VillageInfoController::class, 'getVillage']);
Route::get('info-contact', [VillageInfoController::class, 'getContact']);

// API Get Destination
Route::get('destinations', [DestinationController::class, 'getAllDestinations']);
Route::get('destination', [DestinationController::class, 'getDestination']);

// API Get Category
Route::get('categories', [DestinationController::class, 'getAllCategories']);

// API Get Accomodation
Route::get('homestays', [AccomodationController::class, 'getAllHomestays']);
Route::get('homestay', [AccomodationController::class, 'getHomestay']);
Route::get('room-type', [AccomodationController::class, 'getRoomType']);

Route::get('transportations', [AccomodationController::class, 'getAllTransportations']);

// API Get Tour
Route::get('tours', [TourController::class, 'getAllTours']);
Route::get('tour', [TourController::class, 'getTour']);
