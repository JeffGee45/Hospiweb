<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GetStartedController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\HospitalisationController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\Auth\RegisterController; 
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileUploadController;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Routes pour le téléchargement de fichiers
Route::middleware('auth')->group(function () {
    Route::post('/upload-file', [FileUploadController::class, 'upload'])->name('file.upload');
    Route::delete('/delete-file', [FileUploadController::class, 'delete'])->name('file.delete');
});

// Routes protégées par l'authentification
Route::middleware(['auth', \App\Http\Middleware\CheckGetStarted::class])->group(function () {
    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/get-started', [GetStartedController::class, 'show'])->name('get-started');
    Route::post('/get-started', [GetStartedController::class, 'complete'])->name('get-started.complete');
    // Route centrale pour le tableau de bord, redirige selon le rôle
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- GROUPES DE ROUTES PAR RÔLE ---

    Route::prefix('admin')->middleware('role:Admin')->name('admin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('medecins', MedecinController::class);
        Route::resource('patients', PatientController::class);
        Route::resource('rendez-vous', RendezVousController::class);
        Route::post('rendez-vous/{rendez_vous}/annuler', [RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');
        Route::resource('rapports', RapportController::class)->only(['index']);
        Route::get('rapports/export/consultations', [RapportController::class, 'exportConsultationsParMedecin'])->name('rapports.export.consultations');
        Route::get('rapports/export/hospitalisations', [RapportController::class, 'exportHospitalisationsEnCours'])->name('rapports.export.hospitalisations');
        Route::get('rapports/export/medicaments', [RapportController::class, 'exportMedicamentsPrescrits'])->name('rapports.export.medicaments');
        Route::get('rapports/export/statistiques', [RapportController::class, 'exportStatistiques'])->name('rapports.export.statistiques');
    });

    Route::prefix('secretaire')->middleware('role:Secretaire')->name('secretaire.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'secretaire'])->name('dashboard');
        Route::resource('patients', PatientController::class)->except(['destroy']);
        Route::resource('rendez-vous', RendezVousController::class)->except(['destroy']);
        Route::post('rendez-vous/{rendez_vous}/annuler', [RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');
    });

    Route::prefix('medecin')->middleware('role:Medecin')->name('medecin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'medecin'])->name('dashboard');
        Route::resource('patients', PatientController::class)->only(['index', 'show']);
        
        // Routes pour les rendez-vous des médecins
        Route::resource('rendez-vous', \App\Http\Controllers\Medecin\RendezVousController::class)->only(['index', 'show']);
        Route::post('rendez-vous/{rendez_vous}/annuler', [\App\Http\Controllers\Medecin\RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');
        
        // Routes pour l'exportation iCal
        Route::get('rendez-vous/export/ical', [\App\Http\Controllers\Medecin\IcalController::class, 'index'])->name('rendez-vous.export.ical');
        Route::get('rendez-vous/{rendez_vous}/export/ical', [\App\Http\Controllers\Medecin\IcalController::class, 'show'])->name('rendez-vous.show.ical');
        
        Route::resource('consultations', ConsultationController::class);
        Route::resource('hospitalisations', HospitalisationController::class);
    });

    Route::prefix('patient')->middleware('role:Patient')->name('patient.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'patient'])->name('dashboard');
        
        // Routes pour la gestion des rendez-vous par le patient
        Route::resource('rendez-vous', \App\Http\Controllers\Patient\RendezVousController::class)->only(['index', 'create', 'store', 'show']);
        Route::post('rendez-vous/{id}/annuler', [\App\Http\Controllers\Patient\RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');
    });

    Route::prefix('infirmier')->middleware('role:Infirmier|Infirmier(e)')->name('infirmier.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'infirmier'])->name('dashboard');
        Route::resource('soins', App\Http\Controllers\SoinsController::class);
    });

    Route::prefix('pharmacien')->middleware('role:Pharmacien')->name('pharmacien.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'pharmacien'])->name('dashboard');
        Route::get('pharmacie', [App\Http\Controllers\PharmacieController::class, 'index'])->name('pharmacie.index');
    });

    Route::prefix('caissier')->middleware('role:Caissier')->name('caissier.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'caissier'])->name('dashboard');
        Route::get('facturation', [App\Http\Controllers\FacturationController::class, 'index'])->name('facturation.index');
    });
});