<?php

namespace App\Events;

use AetherUpload\Receiver;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UploadCompleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiver;
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Receiver $receiver, Request $request)
    {
        $this->receiver = $receiver;
        $this->request = $request;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [];
    }
}
