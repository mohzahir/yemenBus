<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            [
                'name' => 'رحلات عبر شركه نقل',
                'descr' => "استكشف جميع الرحلات عن طريق شركه النقل",
                'img' => 'passenger-assets/img/hero/bus-cover.png',
                'slug' => 'bus',
            ],
            [
                'name' => 'نقل الركاب على الماشي',
                'descr' => "استكشف جميع الرحلات عن طريق سيارة خاصه",
                'img' => 'passenger-assets/img/hero/car.jpg',
                'slug' => 'car',
            ],
            [
                'name' => 'رحلات الحج والعمرة',
                'descr' => "استكشف جميع الرحلات الخاصة بالحج والعمرة",
                'img' => 'passenger-assets/img/hero/haj.jpg',
                'slug' => 'haj',
            ],
            [
                'name' => 'مرسول اليمن لنقل الرسائل والبضائع',
                'descr' => "استكشف جميع الرحلات الخاصة بنقل البضائع",
                'img' => 'passenger-assets/img/hero/bus1-old.jpg',
                'slug' => 'msg',
            ],
        ]);
    }
}
