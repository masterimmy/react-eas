<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TenantRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::select('id', 'tenant_name','tenancy_db_email','valid_from', 'valid_till')->latest()->paginate(10);
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
        try {
            $logoFile = $request->file('organization_logo');

            return DB::transaction(function () use ($request, $logoFile) {
                // Process file inside the transaction
                $filepath = base64_encode(file_get_contents($logoFile->path()));

                // Create tenant
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

                // Create domain
                $domain = $tenant->domains()->create(['domain' => $request->organization_domain]);

                // Configure and seed tenant database
                $tenant->configure()->use();

                // Use --seed flag directly instead of db:seed command for better transaction handling
                Artisan::call("migrate", [
                    '--seed'   => true,
                    '--seeder' => 'TenantSeeder',
                    '--force'  => true,
                ]);

                // Create admin user
                $user = new User([
                    'id'          => (string) Str::uuid(),
                    'name'        => $request->organization_user_name,
                    'employee_id' => 'admin',
                    'email'       => $request->organization_user_email,
                    'password'    => bcrypt('admin'),
                    'is_active'   => 0,
                ]);
                $user->save();
                $user->roles()->attach(1, ['user_type' => 'App\Models\User']);

                return true; // Return true to indicate success
            }) ? redirect('/tenants')->with('success', 'Created Successfully')
            : redirect('/tenants')->with('error', 'Creation Failed');

        } catch (\Exception $e) {
            logger()->error('Tenant creation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request'   => $request->all(),
            ]);

            return redirect('/tenants')->with('error', 'Creation Failed: ' . $e->getMessage());
        }
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
