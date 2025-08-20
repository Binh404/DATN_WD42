<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserStoppedTyping  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $fromUserId;
    public $toUserId;
    public function __construct($fromUserId, $toUserId)
    {
         $this->fromUserId = $fromUserId;
        $this->toUserId = $toUserId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
             new PrivateChannel('chat.' . $this->toUserId)
        ];
    }
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->fromUserId,
            'user_name' => auth()->user()->ten_dang_nhap ?? 'Unknown'
        ];
    }
    public function broadcastAs()
    {
        return 'user.stopped-typing';
    }
}
