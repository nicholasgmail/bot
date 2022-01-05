<?php

namespace App\Events\Engine;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PadSorilineEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $messages;
    public $dialog;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($messages, $dialog)
    {
        $this->messages = $messages;
        $this->dialog = $dialog;
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
