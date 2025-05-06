<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //To default add entry in features table

    DB::table('modules')->insert([
      'name' => 'general',
      'category' => 'module',
      'access_to' => 1,
      'is_active' => 1]);

    DB::table('features')->insert([
      [
        'name' => 'geo_fencing',
      ],
      [
        'name' => 'version_counter',
      ]
    ]);
  }
}
