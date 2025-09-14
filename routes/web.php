<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kpi\EngagementType;

Route::get('/', [HomeController::class, 'showHome'])->middleware('auth');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/json/{week}',[EngagementType::class,'engagementType']);

// Pour debug 
// TODO Remettre dans le controller

Route::get('/kpi/type/{week}', function (string $week) {
    return view('kpi.partials.engagement-type', ['week' => $week]);
});

Route::get('/kpi/public', function () {
    return view('kpi.dashboard');
});
