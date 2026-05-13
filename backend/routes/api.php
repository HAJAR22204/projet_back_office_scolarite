<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DemandeController;

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);

Route::post('demandes', [DemandeController::class, 'store']);
Route::get('etudiants/{cne}/historique', [DemandeController::class, 'historique']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::get('demandes', [DemandeController::class, 'index']);
    Route::get('demandes/statistiques', [DemandeController::class, 'statistiques']);
    Route::get('demandes/{id}', [DemandeController::class, 'show']);
    Route::put('demandes/{id}/valider', [DemandeController::class, 'valider']);
    Route::put('demandes/{id}/refuser', [DemandeController::class, 'refuser']);
    Route::put('demandes/{id}/mettre-en-cours', [DemandeController::class, 'mettreEnCours']);
});