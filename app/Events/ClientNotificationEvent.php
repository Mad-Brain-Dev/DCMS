<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $client;
    public $type;
    public $data;

    /**
     * Create a new event instance.
     */
    public function __construct($client, string $type, array $data = [])
    {
        $this->client = $client;
        $this->type   = $type;   // general | installment
        $this->data   = $data;   // dynamic data
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
