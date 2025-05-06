<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('leave_types')->insert([
        'name' =>'Privilege Leave',
        'code' => 'PL',
      ]);

      DB::table('leave_types')->insert([
        'name' =>'Casual Leave',
        'code' => 'CL',
      ]);

      DB::table('leave_types')->insert([
        'name' =>'Sick Leave',
        'code' => 'SL',
      ]);

      DB::table('leave_types')->insert([
        'name' =>'Optional Leave',
        'code' => 'PH',
      ]);

      DB::table('leave_types')->insert([
        'name' =>'CompOff Leave',
        'code' => 'CO',
      ]);


    }
}
