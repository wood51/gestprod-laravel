<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kpi\EngagementType;

Route::get('/', [HomeController::class, 'showHome'])->middleware('auth');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Pour debug 
// TODO Remettre dans le controller

Route::get('/kpi/dashboard', function () {
    return view('kpi.dashboard');
});
Route::get('/kpi/api/engagement-type/{week}',[EngagementType::class,'jsonEngagementType']);
Route::get('/kpi/type/{week}',[EngagementType::class,'renderEngagementType']);
