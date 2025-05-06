<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      LeaveType::where('name', 'Privilege Leave')
        ->update(['code' => 'PL']);
      LeaveType::where('name', 'Casual Leave')
        ->update(['code' => 'CL']);
      LeaveType::where('name', 'Sick Leave')
        ->update(['code' => 'SL']);
      LeaveType::where('name', 'Optional Leave')
        ->update(['code' => 'PH']);
      LeaveType::where('name', 'CompOff Leave')
        ->update(['code' => 'CO']);



    }
}
