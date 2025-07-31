<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load(['sender', 'receiver']);
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->receiver_id),
            new PrivateChannel('chat.' . $this->message->sender_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'message' => $this->message->message,
            'sender_id' => $this->message->sender_id,
            'message_type' => $this->message->message_type,
            // 'file_url' => $this->message->file_url ? asset('storage/'.$this->message->file_url).'?t='.time() : null,
            'file_url' => $this->message->file_url ? url('storage/'.$this->message->file_url) : null,
            'receiver_id' => $this->message->receiver_id,
            'is_read' => $this->message->is_read,
            'created_at' => $this->message->created_at->format('H:i'),
            'created_at_full' => $this->message->created_at->format('Y-m-d H:i:s'),
            'sender' => [
                'id' => $this->message->sender->id,
                'name' => ($this->message->sender->hoSo->ho ?? '') . ' ' . ($this->message->sender->hoSo->ten ?? ''),
                'avatar' => $this->message->sender->hoSo->anh_dai_dien ?? 'assets/images/default.png'
            ],
            'is_own_message' => false
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}
