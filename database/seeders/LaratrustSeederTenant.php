<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LaratrustSeederTenant extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info('Truncating User, Role and Permission tables');
    $this->truncateLaratrustTables();

    $config = config('laratrust_seeder_tenant.role_structure');
    $mapPermission = collect(config('laratrust_seeder_tenant.permissions_map'));
    $mapAccess = collect(config('laratrust_seeder_tenant.access_map'));

    foreach ($config as $key => $modules) {
      $role_name = $key;
      // Create a new role
      $role = \App\Models\Role::create([
        'name' => $role_name,
        'display_name' => ucwords(str_replace('_', ' ', $role_name)),
        'description' => ucwords(str_replace('_', ' ', $role_name)),
      ]);

      $permissions = [];
      $this->command->info('Creating Role '. strtoupper($role_name));
      foreach ($modules as $module => $value) {

        foreach (explode(',', $value) as $p => $perm) {
          $access = "all";
          if(strlen($perm) > 2) {
            $perm_access = explode('-', $perm);
            $perm = $perm_access[0];
            $access = $perm_access[1];
          }
          $permissionValue = $mapPermission->get($perm);
//          logger($permissionValue);
          $accessValue = $mapAccess->get($access);

          $m = \App\Models\Module::firstOrCreate([
            'name' => $module,
            'is_active' => 1,
            'access_to' => 1
          ]);
//          logger($m);

          $assigned_permission = \App\Models\Permission::firstOrCreate([
            'name' => $permissionValue . '-' . $m->name,
            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'description' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'access_to' => "assigned",
            'module_id' => $m->id,
          ])->id;
          $created_permission = \App\Models\Permission::firstOrCreate([
            'name' => $permissionValue . '-' . $m->name,
            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'description' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'access_to' => "created",
            'module_id' => $m->id,
          ])->id;
          $assigned_created_permission = \App\Models\Permission::firstOrCreate([
            'name' => $permissionValue . '-' . $m->name,
            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'description' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'access_to' => "assignedOrCreated",
            'module_id' => $m->id,
          ])->id;
          $all_permission = \App\Models\Permission::firstOrCreate([
            'name' => $permissionValue . '-' . $m->name,
            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'description' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'access_to' => "all",
            'module_id' => $m->id,
          ])->id;
          $group_permission = \App\Models\Permission::firstOrCreate([
            'name' => $permissionValue . '-' . $m->name,
            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'description' => ucfirst($permissionValue) . ' ' . ucfirst($m->name),
            'access_to' => "group",
            'module_id' => $m->id,
          ])->id;
          switch($accessValue) {
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

          $this->command->info('Creating Permission to '.$permissionValue.' for '. $m->name);
        }


      }
      $role->permissions()->sync($permissions);
    }
    if (!empty($userPermission)) {

      foreach ($userPermission as $key => $modules) {

        foreach ($modules as $module => $value) {

          // Create default user for each permission set
          // $user = \App\User::create([
          //     'name' => ucwords(str_replace('_', ' ', $key)),
          //     'email' => $key.'@app.com',
          //     'password' => bcrypt('password'),
          //     'remember_token' => str_random(10),
          // ]);
          $permissions = [];

          foreach (explode(',', $value) as $p => $perm) {

            $permissionValue = $mapPermission->get($perm);

            $permissions[] = \App\Models\Permission::firstOrCreate([
              'name' => $permissionValue . '-' . $module,
              'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
              'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
            ])->id;

            $this->command->info('Creating Permission to '.$permissionValue.' for '. $module);
          }
        }

        // Attach all permissions to the user
        // $user->permissions()->sync($permissions);
      }
    }

    /*
    $config = config('laratrust_seeder.role_structure');
    $userPermission = config('laratrust_seeder.permission_structure');
    $mapPermission = collect(config('laratrust_seeder.permissions_map'));
    foreach ($config as $key => $modules) {

      // Create a new role
      $role = \App\Models\Role::create([
        'name' => $key,
        'display_name' => ucwords(str_replace('_', ' ', $key)),
        'description' => ucwords(str_replace('_', ' ', $key))
      ]);
      $permissions = [];

      $this->command->info('Creating Role '. strtoupper($key));

      // Reading role permission modules
      foreach ($modules as $module => $value) {

        foreach (explode(',', $value) as $p => $perm) {

          $permissionValue = $mapPermission->get($perm);

          $permissions[] = \App\Models\Permission::firstOrCreate([
            'name' => $permissionValue . '-' . $module,
            'display_name' => ucfirst($permissionValue) . ' ' . ucfirst($module),
            'description' => ucfirst($permissionValue) . ' ' . ucfirst($module),
          ])->id;

          $this->command->info('Creating Permission to '.$permissionValue.' for '. $module);
        }
      }

      // Attach all permissions to the role
      $role->permissions()->sync($permissions);

      $this->command->info("Creating '{$key}' user");

    }*/
    DB::table('modules')->insert([
        'name' => "geofencing",
        'is_active' => 0,
        'access_to' => 1
    ]);
  }
  public function truncateLaratrustTables()
  {
    Schema::disableForeignKeyConstraints();
    DB::table('permission_role')->truncate();
    DB::table('permission_user')->truncate();
//    DB::table('role_user')->truncate();
//    \App\Models\User::truncate();
    \App\Models\Role::truncate();
    \App\Models\Permission::truncate();
    \App\Models\Module::truncate();
    Schema::enableForeignKeyConstraints();
  }
}
