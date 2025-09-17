<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kpi\EngagementType;
use App\Http\Controllers\Kpi\Engagement;
use App\Http\Controllers\Kpi\Dashboard;

Route::get('/', [HomeController::class, 'showHome'])->middleware('auth');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Pour debug 
// TODO Remettre dans le controller

Route::get('/kpi/dashboard',[Dashboard::class,'showDashboard'] );
Route::get('/kpi/api/engagement-type/{week}',[EngagementType::class,'jsonEngagementType']);
Route::get('/kpi/type/{week}',[EngagementType::class,'renderEngagementType']);

Route::get('/kpi/api/engagement/{week}',[Engagement::class,'jsonEngagement']);
Route::get('/kpi/engagement/{week}',[Engagement::class,'renderEngagement']);
