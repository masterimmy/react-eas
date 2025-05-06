<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShiftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shift = Shift::create([
            'id' => '599671ec-0cd0-4174-9744-460435561728',
            'display_name' => 'Day Shift',
            'name' => 'day',
            'start_time' => '09:00',
            'end_time' => '18:00',
            'created_at' => now(),
            'updated_at'=>now()
        ]);
    }
}
