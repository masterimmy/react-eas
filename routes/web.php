<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::resource('tenants', \App\Http\Controllers\TenantController::class)->names('tenants');
    Route::get('support', [\App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';