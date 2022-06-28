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
        $this->call([
            ServicesTableSeeder::class,
            SubServicesTableSeeder::class,
            CitiesTableSeeder::class,
            SettingsTableSeeder::class,
            AdminsTableSeeder::class,
            ServicesSubServicesTableSeeder::class,
            ProvidersTableSeeder::class,
            TripsTableSeeder::class,
        ]);
    }
}
