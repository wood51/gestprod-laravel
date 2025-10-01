<?php

use App\Http\Controllers\Api\MachineDataController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    //Route::get('/machines', [MachineDataController::class, 'index']);
    Route::post('/machines', [MachineDataController::class, 'store']);
});



Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('xlsx/ping', fn(\Illuminate\Http\Request $r) => response()->json(['pong' => true]));
});
