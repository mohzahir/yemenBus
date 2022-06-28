<?php

use Illuminate\Database\Seeder;
use App\Trip;

class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Trip::insert([
            'direcation' => 'yts',
            'provider_id' => 1,
            'sub_service_id' => 1,
            'lines_trip' => 'الرياض', 
            'takeoff_city_id' => '4', 
            'arrival_city_id' => '1', 
            'day' => date('Y-m-d'), 
            'coming_time' => date('H:m:s'), 
            'leave_time' => date('H:m:s'), 
            'weight' => 200, 
            'no_ticket' => 200, 
            'note' => null, 
            'price' => 2000, 
            'status' => 'active'
        ]);
    }
}
