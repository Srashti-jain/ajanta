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

class ChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $conv_id;
    public $reciver_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data,$conv_id,$reciver_id)
    {
        $this->data     = $data;
        $this->conv_id = $conv_id;
        $this->reciver_id = $reciver_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['chat-message'];
    }

    public function broadcastAs()
    {
        return 'conversation_'.$this->conv_id.'_user_'.$this->reciver_id;
    }
}
