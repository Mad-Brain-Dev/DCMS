<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ClientNotificationEvent;
use App\Services\MailService;

class SendClientNotificationListener
{
    protected $mailService;
    /**
     * Create the event listener.
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Handle the event.
     */
    public function handle(ClientNotificationEvent $event)
    {
        $this->mailService->send(
            $event->client,
            $event->type,
            $event->data
        );
    }
}
