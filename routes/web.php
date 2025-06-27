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
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // --- GROUPES DE ROUTES PAR RÔLE ---

    // Routes pour l'Admin
    // Routes pour l'Admin
    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('medecins', MedecinController::class);
        Route::get('rapports', [RapportController::class, 'index'])->name('rapports.index');
        Route::get('rapports/export/consultations-par-medecin', [RapportController::class, 'exportConsultationsParMedecin'])->name('rapports.export.consultations');
        Route::get('rapports/export/hospitalisations-en-cours', [RapportController::class, 'exportHospitalisationsEnCours'])->name('rapports.export.hospitalisations');
        Route::get('rapports/export/medicaments-prescrits', [RapportController::class, 'exportMedicamentsPrescrits'])->name('rapports.export.medicaments');
        Route::get('rapports/export/statistiques-patients', [RapportController::class, 'exportStatistiquesPatients'])->name('rapports.export.patients');
        Route::delete('patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    });

    // Routes pour le Médecin
    // Routes pour le Médecin
    Route::middleware('role:Medecin')->group(function () {
        Route::get('patients/{patient}/dossier', [DossierMedicalController::class, 'show'])->name('dossiers.show');
        Route::post('patients/{patient}/dossier', [DossierMedicalController::class, 'store'])->name('dossiers.store');
        Route::resource('patients.consultations', ConsultationController::class)->shallow();
        Route::resource('patients.hospitalisations', HospitalisationController::class)->shallow();
        Route::get('consultations/{consultation}/prescriptions/create', [PrescriptionController::class, 'create'])->name('consultations.prescriptions.create');
        Route::post('consultations/{consultation}/prescriptions', [PrescriptionController::class, 'store'])->name('consultations.prescriptions.store');
    });

    // Routes pour la Secrétaire
    // Routes pour la Secrétaire
    Route::middleware('role:Secretaire')->group(function () {
        Route::resource('rendez-vous', RendezVousController::class);
        Route::get('patients/create', [PatientController::class, 'create'])->name('patients.create');
        Route::post('patients', [PatientController::class, 'store'])->name('patients.store');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes partagées par plusieurs rôles
    |--------------------------------------------------------------------------
    |
    | Ces routes sont définies individuellement pour un contrôle plus fin
    | des permissions.
    |
    */
    // Routes partagées par plusieurs rôles
    Route::get('patients', [PatientController::class, 'index'])->name('patients.index')->middleware('role:Admin,Medecin,Infirmier,Secretaire');
    Route::get('patients/{patient}', [PatientController::class, 'show'])->name('patients.show')->middleware('role:Admin,Medecin,Infirmier');
    Route::get('patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit')->middleware('role:Admin,Secretaire,Medecin');
    Route::put('patients/{patient}', [PatientController::class, 'update'])->name('patients.update')->middleware('role:Admin,Secretaire,Medecin');
    Route::patch('patients/{patient}', [PatientController::class, 'update'])->middleware('role:Admin,Secretaire,Medecin');
    Route::post('patients/{patient}/change-status', [PatientController::class, 'changeStatus'])->name('patients.changeStatus')->middleware('role:Admin,Medecin');

    /*
    |--------------------------------------------------------------------------
    | Routes à implémenter
    |--------------------------------------------------------------------------
    */
    // Routes pour l'Infirmier(e)
    // Routes pour l'Infirmier
    Route::middleware('role:Infirmier')->group(function () {
        Route::get('soins', [\App\Http\Controllers\SoinsController::class, 'index'])->name('soins.index');
    });

    // Routes pour le Pharmacien
    Route::middleware('role:Pharmacien')->group(function () {
        Route::get('pharmacie', [\App\Http\Controllers\PharmacieController::class, 'index'])->name('pharmacie.index');
    });

    // Routes pour le Caissier
    Route::middleware('role:Caissier')->group(function () {
        Route::get('facturation', [\App\Http\Controllers\FacturationController::class, 'index'])->name('facturation.index');
    });
});