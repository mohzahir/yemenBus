<?php


use Illuminate\Database\Seeder;
use App\City;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::insert([
            [
                'name' => 'الرياض',
                'country' => '1',
            ],
            [
                'name' => 'الدمام',
                'country' => '1',
            ],
            [
                'name' => 'مارب',
                'country' => '0',
            ],
            [
                'name' => 'صنعاء',
                'country' => '0',
            ],
        ]);
    }
}
