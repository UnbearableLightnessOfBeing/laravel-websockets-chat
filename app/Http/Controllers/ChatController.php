<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    public function index(int $id) {

        return Inertia::render('ChatPage', [
            'chat' => Chat::all()->where('id', $id)->first()->with(['users', 'messages'])->get()[0],
        ]);
    }

    public function store(int $chatId, Request $request): Response {


        $request->validate([
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'message' => $request->message,
            'user_id' => $request->user()->id,
            'chat_id' => $chatId,
        ]);

        MessageSent::dispatch($message);

        return response(['message' => 'success'], 200);

        // return Redirect::route('chat', [
        //     'id' => $chatId
        // ]);
    }
}
