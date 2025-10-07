<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kpi\Engagement;
use App\Http\Controllers\Kpi\Dashboard;
use App\Http\Controllers\Kpi\Qualite;
use App\Http\Controllers\Kpi\Rendement;

use App\Http\Controllers\Planning\PlanningController;
// use App\Http\Controllers\TempsProduction;

// Page Principale
Route::get('/', [HomeController::class, 'showHome'])->name('home')->middleware('auth');

// Authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard KPI
Route::get('/kpi/dashboard',[Dashboard::class,'showDashboard'] )->name('dashboard');
Route::post('/kpi/api/set-week', [Dashboard::class,'setDashboardWeek']);

Route::get('/kpi/api/engagement-type/{week}',[Engagement::class,'jsonEngagementType']);
Route::get('/kpi/api/engagement/{week}',[Engagement::class,'jsonEngagement']);

Route::get('/kpi/api/respect-engagement/{week}',[Engagement::class,'jsonRespectEngagement']);
Route::get('/kpi/respect-engagement/{week}',[Engagement::class,'renderRespectEngagement']);

Route::get('/kpi/api/rendement-mois/{week}/{nb_week}',[Rendement::class,'jsonRendementMois']);
Route::get('/kpi/rendement-mois/{week}/{nb_week}',[Rendement::class,'renderRendementMois']);

Route::get('kpi/api/qualite/{week}',[Qualite::class,'jsonQualite']);
Route::get('kpi/qualite/{week}',[Qualite::class,'renderQualite']);

Route::get('kpi/api/qualite-mois/{week}/{nb_week}',[Qualite::class,'jsonQualiteMois']);
Route::get('kpi/qualite-mois/{week}/{nb_week}',[Qualite::class,'renderQualiteMois']);

// Planning
Route::get('/planning', [PlanningController::class, 'index'])->name('planning.index');