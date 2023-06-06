<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ChatController extends Controller
{
    public function index(int $id) {

        return Inertia::render('ChatPage', [
            'chat' => Chat::with(['users', 'messages'])->find($id),
        ]);
    }

    public function store(int $chatId, Request $request): Response {


        $request->validate([
            'message' => 'required|string'
        ]);

        //test
        // return response(['message' => [
        //     'user_id' => $request->user()->id, 'chat_id' => $chatId
        // ]], 200);

        $message = Message::create([
            'message' => $request->message,
            'user_id' => $request->user()->id,
            'chat_id' => $chatId,
        ]);


        MessageSent::dispatch($message);

        return response(['message' => 'success'], 200);
    }

    public function openOrCreate() {

        $currentUsersChats = request()->user()->chats;

        // $targetUsersChats = User::find(request()->userId)->chats;

        $hasChat = false;
        $targetChat = null;

        foreach($currentUsersChats as $chat) {
            foreach($chat->users as $user) {
                if($user->id === request()->userId) {
                    $hasChat = true;
                    $targetChat = $chat;
                }
            }
        }

        if(!$hasChat) {
            $targetChat = Chat::create();
            $targetChat->users()->save(request()->user());
            $targetChat->users()->save(User::find(request()->userId));
        }

        return $this->index($targetChat->id);
    }
}
