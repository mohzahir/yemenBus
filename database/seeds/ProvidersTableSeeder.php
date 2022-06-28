<?php

use Illuminate\Database\Seeder;
use App\Provider;

class ProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::insert([
            'name_company' => 'الدامر',
            'service_id' => '3',
            'phone' => '996548738948',
            'city' => 'الرياض',
            'password' => bcrypt('123456'),
        ]);
    }
}
