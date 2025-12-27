<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Inertia\Inertia;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\PublicProfileController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Ruta para VER el dashboard (GET)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Ruta para GUARDAR el perfil (POST)
    Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile');

    // --- RUTAS PARA LINKS ---
    Route::post('/links', [LinkController::class, 'store'])->name('links.store');
    Route::put('/links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// RUTAS PÚBLICAS

// Procesa la donación (POST)
Route::post('/@{username}/support', [PublicProfileController::class, 'sendSupport'])->name('public.support');

// Ver el perfil, GET, Ej: esponsor.com/@....
Route::get('/@{username}', [PublicProfileController::class, 'show'])->name('public.profile');