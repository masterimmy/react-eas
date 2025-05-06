<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Traits\AddRoleModuleAndPermissionTenant;

class add_roster_to_laratrust_tenant_seeder extends Seeder
{
    use AddRoleModuleAndPermissionTenant;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->AddRoleModuleAndPermission([
            'super_admin' => [
                'roster' => 'r-al,c-al,u-al'
            ],
            'admin' => [
                'roster' => 'r-al,c-al,u-al'
            ],
            'manager' => [
                'roster' => 'r-al,c-al,u-al'
            ]
        ]);
    }
}
