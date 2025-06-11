<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use App\Models\MasterMeasurementKey;

class MeasurmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $measurementKeys = [
            ['key_name' => 'Blouse back length'],
            ['key_name' => 'Full Shoulder'],
            ['key_name' => 'Shoulder Strap'],
            ['key_name' => 'Back Neck Depth'],
            ['key_name' => 'Front Neck Depth'],
            ['key_name' => 'Shoulder to Apex'],
            ['key_name' => 'Front Length'],
            ['key_name' => 'Chest (around)'],
            ['key_name' => 'Waist (around)'],
            ['key_name' => 'Sleeve Length'],
            ['key_name' => 'Arm Round'],
            ['key_name' => 'Sleeve Round'],
            ['key_name' => 'Arm Hole'],
        ];


        DB::table('master_measurements_keys')->insert($measurementKeys);
    }
}