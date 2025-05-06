<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;
use Webpatser\Uuid\Uuid;

class TenantSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('teams')->insert([
      "name" => "EAS-CDP",
      "display_name" => "EAS CDP Attendance ",
      "description" => "EAS CDP India User Attendance Management",
    ]);
    $this->call(LaratrustSeederTenant::class);
    $this->call(add_support_to_laratrust_tenant_seeder::class);
    $this->call(add_roster_to_laratrust_tenant_seeder::class);
    $this->call(ShiftsTableSeeder::class);
//    $this->call(RoleUserTableSeeder::class);  
    $this->call(LeaveTypeSeeder::class);
    $this->call(FeatureSeeder::class);
    $this->call(LeaveCodeSeeder::class);
    $this->call(OnboardingTourGuide::class);

    //Feature Module seeder
    $getModule = Module::select('id','name')->whereIn('name', ['attendances','general'])->get();
    $getFeature = Feature::select('id','name')->whereIn('name',['geo_fencing', 'version_counter'])->get();

    DB::table('feature_modules')->insert([
      [
        'feature_id' => $getFeature->where('name','geo_fencing')->first()->id,
        'module_id' => $getModule->where('name','attendances')->first()->id,
        'type' => 'App',
        'value' => '1',
        'access_to' => 1,
        'is_active' => 1
      ],
      [
        'feature_id' => $getFeature->where('name','version_counter')->first()->id,
        'module_id' => $getModule->where('name','general')->first()->id,
        'type' => 'App',
        'value' => '1',
        'access_to' => 1,
        'is_active' => 1
      ]
    ]);

    //Configuration Seeder
    DB::table('configurations')->insert([
        [
          'id' => '1',
          'key'=>'wfh_cutoff',
          'value' => '50',
          'module' => 'wfh',
          'created_at' => now(),
          'updated_at'=>now()
        ],
        [
          'id' => '2',
          'key'=>'wfh_reminder_time',
          'value' => '15:00',
          'module' => 'wfh',
          'created_at' => now(),
          'updated_at'=>now()
        ],
        [
          'id' => '3',
          'key'=>'wfh_notification_text',
          'value' => 'This is notification text',
          'module' => 'wfh',
          'created_at' => now(),
          'updated_at'=>now()
        ],
        [
          'id' => '4',
          'key'=>'tracker_timer',
          'value' => '30',
          'module' => 'tracker',
          'created_at' => now(),
          'updated_at'=>now()
        ],
        [
          'id' => '5',
          'key'=>'wfh_report_notify_text',
          'value' => 'WFH',
          'module' => 'wfh',
          'created_at' => now(),
          'updated_at'=>now()
        ],
      ]
    );

    $client = new ClientRepository();

    $client->createPersonalAccessClient(null, 'Default personal access client', 'http://localhost');
    $client->createPasswordGrantClient(null, 'Default password grant client', 'http://localhost','users');
  }
}
