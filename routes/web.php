<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    Route::get('/table-data/{table}', function (Request $request, string $table) {
        try {
            $valueColumn = $request->query('value', 'id');
            $labelColumn = $request->query('label', 'name');
            
            $data = DB::table($table)
                ->select($valueColumn, $labelColumn)
                ->limit(10)
                ->get()
                ->map(function($item) use ($valueColumn, $labelColumn) {
                    return [
                        'value' => $item->{$valueColumn},
                        'label' => $item->{$labelColumn}
                    ];
                });
                
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error fetching data'], 404);
        }
    });

    Route::resource('tenants', \App\Http\Controllers\TenantController::class)->names('tenants');
    Route::get('support', [\App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';