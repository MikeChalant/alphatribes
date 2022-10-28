<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $name;
    public string $time;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $message, string $name, string $time)
    {
        $this->message = $message;
        $this->name = $name;
        $this->time = $time;
    }

    public function broadcastWith()
    {
        return [
            "message" => $this->message,
            "name" => $this->name,
            "time" => $this->time,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('SendMessageEvent');
    }
}
