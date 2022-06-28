<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ServicesTableSeeder::class);
        $this->call(SubServicesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(ServicesSubServicesTableSeeder::class);
        $this->call(ProvidersTableSeeder::class);
        $this->call(TripsTableSeeder::class);
    }
}
