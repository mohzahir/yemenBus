<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesSubServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services_sub_services')->insert([
            [
                'service_id' => 3,
                'sub_service_id' => 1,
            ],
            [
                'service_id' => 3,
                'sub_service_id' => 2,
            ],
            [
                'service_id' => 2,
                'sub_service_id' => 4,
            ],
            [
                'service_id' => 2,
                'sub_service_id' => 5,
            ],
            [
                'service_id' => 4,
                'sub_service_id' => 3,
            ],
            [
                'service_id' => 4,
                'sub_service_id' => 4,
            ],
            [
                'service_id' => 4,
                'sub_service_id' => 5,
            ],
            [
                'service_id' => 1,
                'sub_service_id' => 5,
            ],
        ]);
    }
}
