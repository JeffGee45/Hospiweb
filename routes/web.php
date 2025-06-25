<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\HospitalisationController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\RapportController;

Route::get('/', function () {
    return view('home');
});
// Routes d'authentification
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Routes pour la gestion des patients (protégées par l'authentification)
Route::middleware(['auth', \App\Http\Middleware\CheckGetStarted::class])->group(function () {
    Route::get('/get-started', [OnboardingController::class, 'show'])->name('get-started');
    Route::post('/get-started', [OnboardingController::class, 'complete'])->name('get-started.complete');
    // Tableau de bord spécifiques aux rôles
    Route::get('/admin/dashboard', [\App\Http\Controllers\DashboardController::class, 'adminDashboard'])->middleware('role:admin')->name('admin.dashboard');
    Route::get('/docteur/dashboard', [\App\Http\Controllers\DashboardController::class, 'docteurDashboard'])->middleware('role:docteur')->name('docteur.dashboard');
    Route::get('/infirmier/dashboard', [\App\Http\Controllers\DashboardController::class, 'infirmierDashboard'])->middleware('role:infirmier')->name('infirmier.dashboard');
    Route::get('/secretaire/dashboard', [\App\Http\Controllers\DashboardController::class, 'secretaireDashboard'])->middleware('role:secretaire')->name('secretaire.dashboard');

    Route::post('patients/{patient}/change-status', [App\Http\Controllers\PatientController::class, 'changeStatus'])->name('patients.changeStatus');
    Route::resource('patients', PatientController::class);


    // Routes pour le dossier médical
    Route::get('patients/{patient}/dossier', [\App\Http\Controllers\DossierMedicalController::class, 'show'])->name('dossiers.show');
    Route::post('patients/{patient}/dossier', [\App\Http\Controllers\DossierMedicalController::class, 'store'])->name('dossiers.store');


    // Routes pour les consultations
    Route::resource('patients.consultations', \App\Http\Controllers\ConsultationController::class)->shallow();


    // Routes pour les hospitalisations
    Route::resource('patients.hospitalisations', HospitalisationController::class)->shallow();


    // Routes pour les prescriptions liées à une consultation
    Route::get('consultations/{consultation}/prescriptions/create', [App\Http\Controllers\PrescriptionController::class, 'create'])->name('consultations.prescriptions.create');
    Route::post('consultations/{consultation}/prescriptions', [PrescriptionController::class, 'store'])->name('consultations.prescriptions.store');


    // Routes pour la gestion des médecins
    Route::resource('medecins', MedecinController::class);


    // Routes pour la gestion des rendez-vous
    Route::post('rendez-vous/{rendez_vous}/annuler', [App\Http\Controllers\RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');
    Route::resource('rendez-vous', RendezVousController::class);


    // Routes pour les rapports et statistiques
    Route::get('rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('rapports/export/consultations-par-medecin', [RapportController::class, 'exportConsultationsParMedecin'])->name('rapports.export.consultations');
    Route::get('rapports/export/hospitalisations-en-cours', [RapportController::class, 'exportHospitalisationsEnCours'])->name('rapports.export.hospitalisations');
    Route::get('rapports/export/medicaments-prescrits', [RapportController::class, 'exportMedicamentsPrescrits'])->name('rapports.export.medicaments');
    Route::get('rapports/export/statistiques-patients', [RapportController::class, 'exportStatistiquesPatients'])->name('rapports.export.patients');
});
