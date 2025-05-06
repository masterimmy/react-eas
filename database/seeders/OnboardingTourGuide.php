<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OnboardingTourGuide extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('onboarding_guide_tours')->insert([
            [
                'step_name' => 'Company Logo',
                'is_completed' => '0',
                'redirect_to' => '/configuration/company-logo?guided_tour=true',
            ],
            [
                'step_name' => 'location_tour',
                'is_completed' => '0',
                'redirect_to' => '/configuration/location/create?guided_tour=true',
            ],

            [
                'step_name' => 'shift_tour',
                'is_completed' => '0',
                'redirect_to' => '/configuration/shifts?guided_tour=true',
            ],

            [
                'step_name' => 'department_tour',
                'is_completed' => '0',
                'redirect_to' => '/configuration/departments?guided_tour=true',
            ],

            [
                'step_name' => 'designation_tour',
                'is_completed' => '0',
                'redirect_to' => '/configuration/designations?guided_tour=true',
            ],

            [
                'step_name' => 'wfh_tour',
                'is_completed' => '0',
                'redirect_to' => '/configuration/wfh?guided_tour=true',
            ],

            [
                'step_name' => 'leave_tour',
                'is_completed' => '0',
                'redirect_to' => '/configuration/leave?guided_tour=true',
            ],



            [
                'step_name' => 'holiday_master_tour',
                'is_completed' => '0',
                'redirect_to' => '/configuration/holiday-master?guided_tour=true',
            ]
        ]);
    }
}
