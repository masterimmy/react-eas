<?php

namespace Database\Seeders;

use App\Traits\AddRoleModuleAndPermissionTenant;
use Illuminate\Database\Seeder;

class add_support_to_laratrust_tenant_seeder extends Seeder
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
                'supports' => 'r-al,c-al,u-al'
            ],
            'admin' => [
                'supports' => 'r-al,c-al,u-al'
            ]
        ]);
    }
}
