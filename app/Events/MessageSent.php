<?php

namespace App\Events;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
        Log::info('MessageSent event fired'); // Add logging
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat'),
        ];
    }

    public function broadcastWith(): array
    {
        $data = (new MessageResource($this->message))->resolve();
        Log::info('Broadcasting with:', $data); // Add logging
        return $data;
    }
}
