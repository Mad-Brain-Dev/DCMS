<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClientNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $type;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($client, string $type, array $data = [])
    {
        $this->client = $client;
        $this->type   = $type;
        $this->data   = $data;
    }

    public function build()
    {
        $subject = match ($this->type) {
            'general'     => 'Case Update Notification',
            'installment' => 'Installment Update Notification',
            'welcome'     => 'Welcome to DCMS Portal',
        };

        if ($this->type === 'welcome'){
            return $this->markdown('emails.clientmail')
                ->with('client', $this->client);
        }else{
            return $this->subject($subject)
                ->view('emails.client-notification')->with('client', $this->client);
        }

    }
}
