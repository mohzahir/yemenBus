<?php

namespace App\Mail;

use App\Reseervation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmReservation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $reseervation;

   public function __construct(Reseervation $reseervation)
    {
        $this->reseervation = $reseervation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // return $this->view('view.name');
       return $this->from('example@example.com')
                ->view('emails.confirmReservation');
    
}
}