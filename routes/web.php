<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

// Landing page o redirección a login/registro
Route::get('/', fn() => redirect()->route('login'));

// Dashboard redirige a lista d'esdeveniments
Route::get('/dashboard', fn() => redirect()->route('events.index'))
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

// Rutes accessibles només amb sessió iniciada (i email verificat)
Route::middleware(['auth', 'verified'])->group(function () {
    // Events públics
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/reserve', [EventController::class, 'reserve'])->name('events.reserve');

    // Perfil d'usuari
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// Rutes d'administració (només admin autenticats)
Route::middleware(['auth', IsAdmin::class])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
         Route::resource('events', AdminEventController::class);
     });

// Autenticació Breeze
require __DIR__ . '/auth.php';
