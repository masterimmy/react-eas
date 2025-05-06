<?php

declare (strict_types = 1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomainOrSubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Inertia\Inertia;

Route::middleware([
    'web',
    InitializeTenancyByDomainOrSubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
    Route::get('/', function () {return redirect()->route('client_login');});
    Route::get('/login', [\App\Http\Controllers\UserController::class, 'create'])->middleware('guest')->name('client_login');

    // Route::get('/', function () {
    //     redirect()->route('login');
    // });

    // Route::post('/login', [UserController::class, 'login']);
});
