<?php

namespace App\Http\Livewire\Chat;

use App\Models\User;
use Livewire\Component;

class UserList extends Component
{
    public $chattedUsers;

    public function mount()
    {
        $this->loadChattedUsers();
    }

    public function loadChattedUsers()
    {
        // Ambil semua user yang pernah diajak chat (baik sebagai sender atau receiver)
        $this->chattedUsers = User::whereIn('id', function($query) {
            $query->select('receiver_id')
                ->from('conversations')
                ->where('sender_id', auth()->id());
        })
        ->orWhereIn('id', function($query) {
            $query->select('sender_id')
                ->from('conversations')
                ->where('receiver_id', auth()->id());
        })
        ->where('id', '!=', auth()->id())
        ->get();
    }

    public function startChat($userId)
    {
        return redirect()->route('chat', ['user_id' => $userId]);
    }

    public function render()
    {
        return view('livewire.chat.user-list');
    }
}
