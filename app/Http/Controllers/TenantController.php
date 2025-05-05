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
            'tenancy_db_name'       => 'tenant_' . $request->organization_domain,
            'id'                    => $request->organization_domain,
            'tenant_name'           => $request->organization_name,
            'tenant_contact_name'   => $request->organization_user_name,
            'tenant_contact_number' => $request->organization_user_mobile,
            'tenancy_db_email'      => $request->organization_user_email,
            'license_user_count'    => $request->organization_license_user_count,
            'valid_from'            => $request->organization_valid_from,
            'valid_till'            => $request->organization_valid_till,
            'tenant_logo'           => $filepath,
            'color_code'            => '#ffffff',
            'base_timezone'         => $request->organization_timezone,
        ]);

        $DomainDetails = $tenant->domains()->create(['domain' => $request->organization_domain]);

        return redirect('/tenants')->with('success', 'Created Successfully');
    }

    public function edit(Tenant $tenant)
    {
        return Inertia::render('Tenants/Create', [
            'tenant' => $tenant,
        ]);
    }

    public function update(TenantRequest $request, Tenant $tenant)
    {
        $tenant->update([
            'tenant_name'           => $request->organization_name,
            'tenant_contact_name'   => $request->organization_user_name,
            'tenant_contact_number' => $request->organization_user_mobile,
            'tenancy_db_email'      => $request->organization_user_email,
            'license_user_count'    => $request->organization_license_user_count,
            'valid_from'            => $request->organization_valid_from,
            'valid_till'            => $request->organization_valid_till,
            'base_timezone'         => $request->organization_timezone,
        ]);
        return redirect('/tenants')->with('success', 'Updated Successfully');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index')->with('success', 'Deleted successfully');
    }
}
