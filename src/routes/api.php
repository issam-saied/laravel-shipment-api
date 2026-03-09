<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentOptionsController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

/*Route::middleware('jwt.auth')->group(function () {
    Route::get('/shipment-options', [ShipmentOptionsController::class, 'index']);
});*/



Route::get('/shipment-options', [ShipmentOptionsController::class, 'index']);



