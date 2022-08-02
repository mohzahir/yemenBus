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


        return (new WhatsAppMessage)
            ->content("Your {$company} reservation of {$this->reservation->trip->title} has shipped and should be delivered on {$deliveryDate}. Details: {$reservationUrl}");
    }
}
