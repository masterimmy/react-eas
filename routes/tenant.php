<?php

declare (strict_types = 1);

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomainOrSubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomainOrSubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/', function () {return redirect()->route('tenant_login');});
    Route::get('/login', [\App\Http\Controllers\UserController::class, 'create'])->name('tenant_login');
    Route::post('/login', [\App\Http\Controllers\UserController::class, 'store'])->name('tenant_login_post');
    Route::post('/logout', [\App\Http\Controllers\UserController::class, 'destroy'])->name('tenant_logout');

    
    Route::get('settings/profile', [\App\Http\Controllers\UserController::class, 'profile_edit'])->name('tenant_profile.edit');
    Route::get('settings/password', function () {return Inertia::render('Clients/settings/password');})->name('tenant_password');
    Route::get('settings/appearance', function () {return Inertia::render('Clients/settings/appearance');})->name('tenant_appearance');
    Route::get('/dashboard', function () {return Inertia::render('Clients/dashboard');})->name('client_dashboard');

    //Employees
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class)->names('employees');

});
