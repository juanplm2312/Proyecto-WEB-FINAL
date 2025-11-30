<?php

namespace App\Mail;

use App\Models\Exchange;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExchangeCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $exchange;

    public function __construct(Exchange $exchange)
    {
        $this->exchange = $exchange;
    }

    public function build()
    {
        return $this->subject('¡Has recibido un nuevo intercambio!')
                    ->markdown('emails.exchanges.created');
    }
}
