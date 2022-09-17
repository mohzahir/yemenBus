<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\WhatsAppChannel;
use App\Reseervation;

class ReservationDone extends Notification
{
    use Queueable;


    public $reservation;

    public function __construct(Reseervation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable)
    {
        return [WhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        $reservationUrl = url("/passengers/order/{$this->reservation->id}");
        $company = 'Acme';
        $deliveryDate = $this->reservation->created_at->addDays(4)->toFormattedDateString();

        $body = "
            حجوزات يمن باص رقم الحجز: " . $this->reservation->id . ", يمكنك المتابعة على الرابط التالي:
            https://www.yemenbus.com/passengers/order/" . $this->reservation->id . "

            يمكن التواصل على الأرقام الاتية على الوتساب
            https://iwtsp.com/966507276370

            خدماتنا للمعتمر والحاج اليمني:

            *خدمة حجز تذاكر الباصات الى اليمن
            *خدمة نقل المسافر الى محطة الركاب
            *خدمة حجز برنامج حج وعمرة
            *خدمة حجز غرفة فندقية بمكة والمدينة
            *خدمة نقل عفش الى اليمن
            *خدمة التوصيل بين المدن السعودية
            *خدمة قطع تزاكر القطار بمكة والمدينة
            *خدمة قطع تذاكر طيران
            
            جميع الخدمات مدفوعة الأجر 30 ريال سعودي\للخدمة
        ";


        return (new WhatsAppMessage)
            // ->content("Your {$company} reservation of {$this->reservation->trip->title} has shipped and should be delivered on {$deliveryDate}. Details: {$reservationUrl}");
            // ->content("حجوزات يمن باص رقم الحجز:  " . $this->reservation->id . "  يمكنك المتابعه على الرابط التالي :https://www.yemenbus.com/passengers/order/" . $this->reservation->id);
            ->content($body);
    }
}
