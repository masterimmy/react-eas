<?php
namespace App\Traits;

trait AddRoleModuleAndPermissionTenant
{
    public function AddRoleModuleAndPermission($roles)
    {
        $mapPermission = collect(config('laratrust_seeder_tenant.permissions_map'));
        $mapAccess     = collect(config('laratrust_seeder_tenant.access_map'));

        foreach ($roles as $key => $modules) {
            $role_name = $key;
            // Create a new role
            $role = \App\Models\Role::firstOrCreate(
                [
                    'name' => $role_name,
                ],
                [
                    'display_name' => ucwords(str_replace('_', ' ', $role_name)),
                    'description'  => ucwords(str_replace('_', ' ', $role_name)),
                ]
            );
            $permissions = [];
            \Log::info('Creating Role ' . strtoupper($role_name));
            foreach ($modules as $module => $value) {

                foreach (explode(',', $value) as $p => $perm) {
                    $access = "all";
                    if (strlen($perm) > 2) {
                        $perm_access = explode('-', $perm);
                        $perm        = $perm_access[0];
                        $access      = $perm_access[1];
                    }
                    $permissionValue = $mapPermission->get($perm);
                    $accessValue     = $mapAccess->get($access);

                    $m = \App\Models\Module::firstOrCreate([
                        'name'      => $module,
                        'is_active' => 1,
                        'access_to' => 1,
                    ]);

                    $assigned_permission = \App\Models\Permission::firstOrCreate([
                        'name'         => $permissionValue . '-' . $m->name,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'description'  => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'access_to'    => "assigned",
                        'module_id'    => $m->id,
                    ])->id;
                    $created_permission = \App\Models\Permission::firstOrCreate([
                        'name'         => $permissionValue . '-' . $m->name,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'description'  => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'access_to'    => "created",
                        'module_id'    => $m->id,
                    ])->id;
                    $assigned_created_permission = \App\Models\Permission::firstOrCreate([
                        'name'         => $permissionValue . '-' . $m->name,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'description'  => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'access_to'    => "assignedOrCreated",
                        'module_id'    => $m->id,
                    ])->id;
                    $all_permission = \App\Models\Permission::firstOrCreate([
                        'name'         => $permissionValue . '-' . $m->name,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'description'  => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'access_to'    => "all",
                        'module_id'    => $m->id,
                    ])->id;
                    $group_permission = \App\Models\Permission::firstOrCreate([
                        'name'         => $permissionValue . '-' . $m->name,
                        'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'description'  => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
                        'access_to'    => "group",
                        'module_id'    => $m->id,
                    ])->id;
                    switch ($accessValue) {
                        case 'assigned':
                            $permissions[] = $assigned_permission;
                            break;
                        case 'created':
                            $permissions[] = $created_permission;
                            break;
                        case 'assignedOrCreated':
                            $permissions[] = $assigned_created_permission;
                            break;
                        case 'all':
                            $permissions[] = $all_permission;
                            break;
                        case 'group':
                            $permissions[] = $group_permission;
                            break;
                        default:
                            $permissions[] = $all_permission;
                            break;
                    }

                    \Log::info('Creating Permission to ' . $permissionValue . ' for ' . $m->name);
                }

            }
            $role->permissions()->attach($permissions);
        }
        if (! empty($userPermission)) {

            foreach ($userPermission as $key => $modules) {

                foreach ($modules as $module => $value) {

                    $permissions = [];

                    foreach (explode(',', $value) as $p => $perm) {

                        $permissionValue = $mapPermission->get($perm);

                        $permissions[] = \App\Models\Permission::firstOrCreate([
                            'name'         => $permissionValue . '-' . $module,
                            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
                            'description'  => ucfirst($permissionValue) . ' ' . ucfirst($module),
                        ])->id;

                        \Log::info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                    }
                }
            }
        }
    }
}
