<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\UserTyping;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::with('user')->latest()->take(5)->get()->reverse();
        return MessageResource::collection($messages);
    }

    public function store(StoreMessageRequest $request)
    {
        $message          = new Message();
        $message->user_id = Auth::id(); // Get authenticated user's ID
        $message->content = $request->validated('content');
        $message->save();

        $message->load('user');

        // Broadcast the message using Reverb
        broadcast(new MessageSent($message));

        return new MessageResource($message);
    }

    public function typing()
    {
        broadcast(new UserTyping());
        return response()->noContent();
    }
}
