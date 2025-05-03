<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantRequest;
use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::latest()->paginate(10);

        return Inertia::render('Tenants/Index', [
            'tenants' => $tenants,
        ]);
    }

    public function create()
    {
        return Inertia::render('Tenants/Create');
    }

    public function store(TenantRequest $request)
    {
        $filepath = base64_encode(file_get_contents($request->file('organization_logo')->path()));

        $tenant = Tenant::create([
            'tenancy_db_name'    => 'tenant_' . $request->organization_domain,
            'id'                 => $request->organization_domain,
            'tenant_name'        => $request->organization_name,
            'tenancy_db_email'   => $request->organization_user_email,
            'license_user_count' => $request->organization_license_user_count,
            'valid_from'         => $request->organization_valid_from,
            'valid_till'         => $request->organization_valid_till,
            'tenant_logo'        => $filepath,
            'color_code'         => '#ffffff',
            'base_timezone'      => $request->organization_timezone,
        ]);

        $DomainDetails = $tenant->domains()->create(['domain' => $request->organization_domain]);

        $tenant->configure()->use();

        Artisan::call('migrate');

        return redirect('/tenants')->with('success', 'Created Successfully');
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
