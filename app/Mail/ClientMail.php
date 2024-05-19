<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientMail extends Mailable
{
    use Queueable, SerializesModels;

<<<<<<< HEAD
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    public function build(){
        return $this->markdown('emails.clientmail')
        ->with('data', $this->data);
    }

    /**
     * Get the attachments for the message.
=======
    public $client;

    /**
     * Create a new message instance.
>>>>>>> rk_12_5
     *
     * @param array $client
     * @return void
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.clientmail')
                    ->with('client', $this->client);
    }
}
