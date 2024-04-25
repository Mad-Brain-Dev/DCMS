<?php

namespace App\Listeners;

use App\Events\NewClientCreated;
use App\Mail\ClientMail;
use App\Models\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendClientWelcomeMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewClientCreated $event): void
    {
        $client = Client::first();
        Mail::to($client->email)->send(new ClientMail($event->client));
    }
}
