<?php

use App\Http\Controllers\TypeExamenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (\Illuminate\Http\Request $request) {
    return $request->user();
});

// Routes pour la gestion des types d'examens
Route::prefix('types-examens')->group(function () {
    Route::get('/', [TypeExamenController::class, 'index']);
    Route::get('/categories', [TypeExamenController::class, 'categories']);
    Route::post('/', [TypeExamenController::class, 'store']);
    Route::get('/{typeExamen}', [TypeExamenController::class, 'show']);
    Route::put('/{typeExamen}', [TypeExamenController::class, 'update']);
    Route::delete('/{typeExamen}', [TypeExamenController::class, 'destroy']);
});

// Routes pour la gestion des paramètres d'examens
Route::prefix('parametres-examens')->group(function () {
    // À implémenter plus tard
});
