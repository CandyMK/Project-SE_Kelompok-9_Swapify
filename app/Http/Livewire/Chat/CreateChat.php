<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class CreateChat extends Component
{
    public $users;

    public function checkconversation($receiverId)
    {
        $conversation = Conversation::where(function($query) use ($receiverId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)
                ->where('receiver_id', auth()->id());
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $receiverId,
                'last_time_message' => null,
            ]);
        }

        // Redirect langsung ke halaman chat dengan receiver_id
        return redirect()->route('chat', ['key' => $receiverId]);
    }


    public function render()
    {
        $this->users = User::whereIn('id', function($query) {
            $query->select('receiver_id')->from('conversations')->where('sender_id', auth()->id());
        })->orWhereIn('id', function($query) {
            $query->select('sender_id')->from('conversations')->where('receiver_id', auth()->id());
        })->where('id', '!=', auth()->id())->get();

        return view('livewire.chat.create-chat');
    }
}
