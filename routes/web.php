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
        Route::resource('patients', PatientController::class);
        Route::resource('rendez-vous', RendezVousController::class);
        Route::post('rendez-vous/{rendez_vous}/annuler', [RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');
        Route::resource('rapports', RapportController::class)->only(['index']);
        Route::get('rapports/export/consultations', [RapportController::class, 'exportConsultationsParMedecin'])->name('rapports.export.consultations');
        Route::get('rapports/export/hospitalisations', [RapportController::class, 'exportHospitalisationsEnCours'])->name('rapports.export.hospitalisations');
        Route::get('rapports/export/medicaments', [RapportController::class, 'exportMedicamentsPrescrits'])->name('rapports.export.medicaments');
        Route::get('rapports/export/statistiques', [RapportController::class, 'exportStatistiques'])->name('rapports.export.statistiques');
    });

    Route::prefix('secretaire')->middleware('role:Secrétaire')->name('secretaire.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'secretaire'])->name('dashboard');
        Route::resource('patients', PatientController::class)->except(['destroy']);
        
        // Gestion des rendez-vous
        Route::prefix('rendez-vous')->name('rendez-vous.')->group(function () {
            Route::get('/', [RendezVousController::class, 'calendrier'])->name('index');
            Route::get('/events', [RendezVousController::class, 'getEvents'])->name('events');
            Route::post('/{rendez_vous}/annuler', [RendezVousController::class, 'annuler'])->name('annuler');
            Route::get('/create', [RendezVousController::class, 'create'])->name('create');
            Route::post('/', [RendezVousController::class, 'store'])->name('store');
            Route::get('/{rendez_vous}/edit', [RendezVousController::class, 'edit'])->name('edit');
            Route::put('/{rendez_vous}', [RendezVousController::class, 'update'])->name('update');
        });
    });

    Route::prefix('medecin')->middleware('role:Médecin')->name('medecin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'medecin'])->name('dashboard');
        Route::resource('patients', PatientController::class)->only(['index', 'show']);
        
        // Gestion des consultations
        Route::resource('patients.consultations', \App\Http\Controllers\ConsultationController::class, [
            'names' => [
                'index' => 'patients.consultations.index',
                'create' => 'patients.consultations.create',
                'store' => 'patients.consultations.store',
                'show' => 'patients.consultations.show',
                'edit' => 'patients.consultations.edit',
                'update' => 'patients.consultations.update',
                'destroy' => 'patients.consultations.destroy'
            ]
        ])->parameters([
            'consultations' => 'consultation'
        ]);
        
        // Suppression de la route redondante
        // Route::resource('consultations', ConsultationController::class);
        
        // Gestion des rendez-vous
        Route::resource('rendez-vous', \App\Http\Controllers\Medecin\RendezVousController::class)->only(['index', 'show']);
        Route::post('rendez-vous/{rendez_vous}/annuler', [\App\Http\Controllers\Medecin\RendezVousController::class, 'annuler'])->name('rendez-vous.annuler');
        
        // Routes pour l'exportation iCal
        Route::get('rendez-vous/export/ical', [\App\Http\Controllers\Medecin\IcalController::class, 'index'])->name('rendez-vous.export.ical');
        Route::get('rendez-vous/{rendez_vous}/export/ical', [\App\Http\Controllers\Medecin\IcalController::class, 'show'])->name('rendez-vous.show.ical');
        
        Route::resource('consultations', ConsultationController::class);
        Route::resource('hospitalisations', HospitalisationController::class);
        
        // Gestion des ordonnances
        Route::prefix('ordonnances')->name('ordonnances.')->group(function () {
            Route::get('/', [App\Http\Controllers\Medecin\OrdonnanceController::class, 'index'])->name('index');
            Route::get('/create/{consultation?}', [App\Http\Controllers\Medecin\OrdonnanceController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Medecin\OrdonnanceController::class, 'store'])->name('store');
            Route::get('/{ordonnance}', [App\Http\Controllers\Medecin\OrdonnanceController::class, 'show'])->name('show');
            Route::get('/{ordonnance}/edit', [App\Http\Controllers\Medecin\OrdonnanceController::class, 'edit'])->name('edit');
            Route::put('/{ordonnance}', [App\Http\Controllers\Medecin\OrdonnanceController::class, 'update'])->name('update');
            Route::delete('/{ordonnance}', [App\Http\Controllers\Medecin\OrdonnanceController::class, 'destroy'])->name('destroy');
            
            // Génération PDF
            Route::get('/{ordonnance}/pdf', [App\Http\Controllers\Medecin\OrdonnanceController::class, 'generatePdf'])->name('pdf');
        });
    });

    Route::prefix('patient')->middleware('role:Patient')->name('patient.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'patient'])->name('dashboard');
        Route::resource('rendez-vous', RendezVousController::class)->only(['index', 'show']);
    });

    Route::prefix('infirmier')->middleware('role:Infirmier|Médecin')->name('infirmier.')->group(function () {
        // Tableau de bord
        Route::get('dashboard', [DashboardController::class, 'infirmier'])->name('dashboard');
        
        // Gestion des patients
        Route::get('patients', [App\Http\Controllers\PatientController::class, 'index'])->name('patients.index');
        Route::get('patients/search', [App\Http\Controllers\PatientController::class, 'search'])->name('patients.search');
        
        // Gestion des soins
        Route::prefix('soins')->name('soins.')->group(function () {
            // Liste des soins à effectuer (page d'accueil)
            Route::get('/', [App\Http\Controllers\SoinsController::class, 'index'])->name('index');
            
            // Historique des soins
            Route::get('/historique', [App\Http\Controllers\SoinsController::class, 'historique'])->name('historique');
            
            // Création et gestion des soins
            Route::get('/create/{patient?}', [App\Http\Controllers\SoinsController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\SoinsController::class, 'store'])->name('store');
            Route::get('/{soin}/edit', [App\Http\Controllers\SoinsController::class, 'edit'])->name('edit');
            Route::put('/{soin}', [App\Http\Controllers\SoinsController::class, 'update'])->name('update');
            Route::delete('/{soin}', [App\Http\Controllers\SoinsController::class, 'destroy'])->name('destroy');
            Route::get('/{soin}', [App\Http\Controllers\SoinsController::class, 'show'])->name('show');
            
            // Actions sur les soins
            Route::post('/{soin}/terminer', [App\Http\Controllers\SoinsController::class, 'terminer'])->name('terminer');
            Route::post('/{soin}/annuler', [App\Http\Controllers\SoinsController::class, 'annuler'])->name('annuler');
            
            // Export et partage
            Route::get('/{soin}/pdf', [App\Http\Controllers\SoinsController::class, 'generatePdf'])->name('pdf');
            Route::get('/{soin}/email', [App\Http\Controllers\SoinsController::class, 'showEmailForm'])->name('email.form');
            Route::post('/{soin}/email', [App\Http\Controllers\SoinsController::class, 'sendEmail'])->name('email.send');
        });
        
        // Gestion des observations
        Route::prefix('observations')->name('observations.')->group(function () {
            Route::get('/', [App\Http\Controllers\ObservationController::class, 'index'])->name('index');
            Route::get('/create/{patient?}', [App\Http\Controllers\ObservationController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\ObservationController::class, 'store'])->name('store');
            Route::get('/{observation}/edit', [App\Http\Controllers\ObservationController::class, 'edit'])->name('edit');
            Route::put('/{observation}', [App\Http\Controllers\ObservationController::class, 'update'])->name('update');
            Route::delete('/{observation}', [App\Http\Controllers\ObservationController::class, 'destroy'])->name('destroy');
            Route::get('/{observation}', [App\Http\Controllers\ObservationController::class, 'show'])->name('show');
        });
    });

    Route::prefix('pharmacien')->middleware('role:Pharmacien')->name('pharmacien.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'pharmacien'])->name('dashboard');
        Route::get('pharmacie', [App\Http\Controllers\PharmacieController::class, 'index'])->name('pharmacie.index');
        Route::post('pharmacie/{prescription}/valider', [App\Http\Controllers\PharmacieController::class, 'valider'])->name('pharmacie.valider');
        Route::get('pharmacie/historique', [App\Http\Controllers\PharmacieController::class, 'historique'])->name('pharmacie.historique');
        // Gestion du stock
        Route::get('stock', [App\Http\Controllers\Pharmacien\StockController::class, 'index'])->name('stock.index');
        // Gestion des médicaments
        Route::resource('medicaments', App\Http\Controllers\Pharmacien\MedicamentController::class)->only(['index']);
    });

    Route::prefix('caissier')->middleware('role:Caissier')->name('caissier.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'caissier'])->name('dashboard');
        Route::get('facturation', [App\Http\Controllers\FacturationController::class, 'index'])->name('facturation.index');
    });
});