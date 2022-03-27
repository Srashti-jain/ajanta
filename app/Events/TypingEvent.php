<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TypingEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conv_id;
    public $receiver;
    public $typingstatus;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($conv_id = 1,$receiver,$typingstatus)
    {
        $this->conv_id = $conv_id;
        $this->receiver = $receiver;
        $this->typingstatus = $typingstatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['typing-channel'];
    }

    public function broadcastAs()
    {
        return 'typing-event-conv-'.$this->conv_id.'-user-'.$this->receiver;
    }
}
