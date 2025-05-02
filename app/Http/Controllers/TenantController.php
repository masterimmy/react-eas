<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantRequest;
use App\Models\Tenant;
use Inertia\Inertia;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::latest()->paginate(10);

        return Inertia::render('Tenants/Index', [
            'tenants' => $tenants
        ]);
    }

    public function create()
    {
        return Inertia::render('Tenants/Create');
    }

    public function store(TenantRequest $request): \Illuminate\Http\RedirectResponse
    {
        Tenant::create($request->validated());
        return redirect()->route('tenants.index')->with('success', 'Created successfully');
    }

    public function show(Tenant $tenant): \Illuminate\Contracts\View\View
    {
        return view('tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant): \Illuminate\Contracts\View\View
    {
        return view('tenants.edit', compact('tenant'));
    }

    public function update(TenantRequest $request, Tenant $tenant): \Illuminate\Http\RedirectResponse
    {
        $tenant->update($request->validated());
        return redirect()->route('tenants.index')->with('success', 'Updated successfully');
    }

    public function destroy(Tenant $tenant): \Illuminate\Http\RedirectResponse
    {
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Deleted successfully');
    }
}
