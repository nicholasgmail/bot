<?php

namespace App\Events\Recruiting;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CharityEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $storyline;
    public $upshot;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($storyline, $upshot)
    {
        $this->storyline = $storyline;
        $this->upshot = $upshot;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
