<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kpi\Engagement;
use App\Http\Controllers\Kpi\Dashboard;
use App\Http\Controllers\Kpi\Rendement;
use App\Http\Controllers\TempsProduction;

Route::get('/', [HomeController::class, 'showHome'])->middleware('auth');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Pour debug 
//Route::get('tp',[TempsProduction::class,'tempsProduction']);

Route::get('/kpi/dashboard',[Dashboard::class,'showDashboard'] );

Route::get('/kpi/api/engagement-type/{week}',[Engagement::class,'jsonEngagementType']);
Route::get('/kpi/api/engagement/{week}',[Engagement::class,'jsonEngagement']);

Route::get('/kpi/api/respect-engagement/{week}',[Engagement::class,'jsonRespectEngagement']);
Route::get('/kpi/respect-engagement/{week}',[Engagement::class,'renderRespectEngagement']);

Route::get('/kpi/api/rendement/{week}',[Rendement::class,'jsonRendementMois']);