<?php

namespace App\Http\Livewire\Chat;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;

class Main extends Component
{
    public $key;
    public $selectedConversation;
    public $messages = [];

    public function mount($key = null)
    {
        if ($key) {
            $user = User::findOrFail($key);

            $this->selectedConversation = Conversation::where(function($query) use ($user) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $user->id);
            })->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', auth()->id());
            })->first();

            if (!$this->selectedConversation) {
                $this->selectedConversation = Conversation::create([
                    'sender_id' => auth()->id(),
                    'receiver_id' => $user->id,
                    'last_time_message' => null,
                ]);
            }

            $this->loadMessages();
        }
    }

    public function loadMessages()
    {
        if ($this->selectedConversation) {
            $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
                ->orderBy('created_at', 'asc')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.chat.main');
    }
}
