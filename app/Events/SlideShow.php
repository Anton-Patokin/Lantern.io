<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SlideShow implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $roomTitle;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($roomTitle)
    {
        $this->roomTitle = $roomTitle;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('test-channel');
    }
}
