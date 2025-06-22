<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// Page d'accueil - redirige vers la connexion
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Routes pour la gestion des patients (protégées par l'authentification)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
    $patients = \App\Models\Patient::all();
    return view('dashboard', ['patients' => $patients]);
})->name('dashboard');

    Route::resource('patients', PatientController::class);

    // Routes pour le dossier médical
    Route::get('patients/{patient}/dossier', [\App\Http\Controllers\DossierMedicalController::class, 'show'])->name('dossiers.show');
    Route::post('patients/{patient}/dossier', [\App\Http\Controllers\DossierMedicalController::class, 'store'])->name('dossiers.store');
});

