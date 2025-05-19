<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EventController as AdminEventController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Només els usuaris autentificats podran accedir a aquestes rutes
Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

     // Ruta per mostra el llistat d'esdeveniments
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    
    // Ruta per veure en detall els esdeveniments.
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    
    // Ruta per procesar la reserva per a un esdeveniment
    Route::post('/events/{id}/reserve', [EventController::class, 'reserve'])->name('events.reserve');
});

// Només l'adiministrador podra entrar aqui
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', AdminEventController::class);
});
require __DIR__.'/auth.php';
