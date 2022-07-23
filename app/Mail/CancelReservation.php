<?php

namespace App\Mail;

use App\Reseervation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelReservation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $creseervation;

    public function __construct(Reseervation $creseervation)
    {
        $this->creseervation = $creseervation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->from('info@yemenbus.com')
            ->view('emails.cancelReservation');
    }
}
