<?php

namespace App\Console;

use App\Competition;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function() {
            $competitions = Competition::where('status', 'active')->where('finish_at', '<=', now())->get();
            foreach ($competitions as $competition) {
                $competition->status = 'finished';
                $winner_user = $competition->participants()->inRandomOrder()->first();
                $winner_message = 'تهانينا! لقد ربحت في قرعة يمن باص، برجاء متابعة التسجيل على ' . $competition->booking_link;
                $result_phone_message = 'تم انتهاء قرعة. ' . ($winner_user == null ? 'لم يكن هناك مشاركين ولا يوجد فائز' : "الفائز هو صاحب الرقم +$winner_user->phone" );
                if ($winner_user != null) {
                    $competition->winner_id = $winner_user->id;
                    // Send SMS to the winner
                    sendSMS($winner_user->phone_country_code, $winner_user->phone, $winner_message);
                }

                // Send SMS to $competition->result_phone
                sendSMS($competition->result_phone_country_code, $competition->result_phone, $result_phone_message);
                
                $competition->save();
            }
        })->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
