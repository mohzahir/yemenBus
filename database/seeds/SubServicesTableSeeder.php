<?php

use Illuminate\Database\Seeder;
use App\SubService;


class SubServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubService::insert([
            [
                'name' => 'عمرة',
                'slug' => 'omra',
            ],
            [
                'name' => 'حج',
                'slug' => 'haj',
            ],
            [
                'name' => 'نقل عفش',
                'slug' => 'assets',
            ],
            [
                'name' => 'طرود ورسائل',
                'slug' => 'sms',
            ],
            [
                'name' => 'نقل ركاب',
                'slug' => 'passengers',
            ]
        ]);
    }
}
