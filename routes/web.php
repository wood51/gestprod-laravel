<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BonLivraison\BonLivraisons;
use App\Http\Controllers\BonLivraison\PdfBonLivraison;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Kpi\Engagement;
use App\Http\Controllers\Kpi\Dashboard;
use App\Http\Controllers\Kpi\Qualite;
use App\Http\Controllers\Kpi\Rendement;
use App\Http\Controllers\PageGarde;
use App\Http\Controllers\Realisation\RealisationController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommandeImportController;
use App\Http\Controllers\PdpController;
use App\Models\BonLivraison;

// use App\Http\Controllers\TempsProduction;
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard KPI
Route::get('/kpi/dashboard', [Dashboard::class, 'showDashboard'])->name('dashboard');
Route::post('/kpi/api/set-week', [Dashboard::class, 'setDashboardWeek']);

Route::get('/kpi/api/engagement-type/{week}', [Engagement::class, 'jsonEngagementType']);
Route::get('/kpi/api/engagement/{week}', [Engagement::class, 'jsonEngagement']);

Route::get('/kpi/api/respect-engagement/{week}', [Engagement::class, 'jsonRespectEngagement']);
Route::get('/kpi/respect-engagement/{week}', [Engagement::class, 'renderRespectEngagement']);

Route::get('/kpi/api/rendement-mois/{week}/{nb_week}', [Rendement::class, 'jsonRendementMois']);
Route::get('/kpi/rendement-mois/{week}/{nb_week}', [Rendement::class, 'renderRendementMois']);

Route::get('kpi/api/qualite/{week}', [Qualite::class, 'jsonQualite']);
Route::get('kpi/qualite/{week}', [Qualite::class, 'renderQualite']);

Route::get('kpi/api/qualite-mois/{week}/{nb_week}', [Qualite::class, 'jsonQualiteMois']);
Route::get('kpi/qualite-mois/{week}/{nb_week}', [Qualite::class, 'renderQualiteMois']);


Route::get('/pa/import', [CommandeImportController::class, 'create']);
Route::post('/pa/import', [CommandeImportController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'showHome'])->name('home');

    // Planning
    Route::get('/realisation', [RealisationController::class, 'index'])->name('realisation.index');
    Route::get('/realisation/rows', [RealisationController::class, 'rows'])->name('realisation.rows');
    Route::post('/realisations/create', [BonLivraisons::class, 'createBl'])
        ->name('realisations.createBl');

    // // Bon de livraisons
    route::get('bl', [BonLivraisons::class, 'index'])->name('bl.index');
    route::post('bl/new', [BonLivraisons::class, 'newBl'])->name('bl.create');
    route::get('bl/{no_bl}', [BonLivraisons::class, 'showBlNumber'])->name('bl.show');
    route::patch('/bl/validate/{no_bl}', [BonLivraisons::class, 'validateBl'])->name('bl.validate');
    route::delete('/bl/delete/{no_bl}', [BonLivraisons::class, 'deleteBl'])->name('bl.delete');

    // Test design
    route::get('/garde/{no_bl}', [PageGarde::class, 'generatePageGarde'])->name('garde.pdf');
    route::get('bl/pdf/{no_bl}', [PdfBonLivraison::class, 'makePdf'])->name('bl.pdf');

    // Route::resource('commandes', CommandeController::class)
    // ->only(['index', 'show']);

    route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');
    route::get('/commandes/{commande}', [CommandeController::class, 'show'])->name('commandes.show');
    route::get('/pdp', [PdpController::class, 'index'])->name('pdp.index');
});


