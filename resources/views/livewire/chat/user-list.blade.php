<!-- resources/views/livewire/chat/user-list.blade.php -->
<div>
    <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
        <input type="text" placeholder="Search users..." class="w-full px-3 py-1 text-sm border rounded-md">
    </div>
    
    @if($chattedUsers->isEmpty())
        <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
            No chat history yet. Start a new chat to see users here.
        </div>
    @else
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($chattedUsers as $user)
                <li wire:click="startChat({{ $user->id }})" 
                    class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer flex items-center">
                    <img src="{{ $user->photo ? asset('storage/profile-photos/'.$user->photo) : 'https://ui-avatars.com/api/?name='.$user->username }}" 
                        class="w-8 h-8 rounded-full mr-3">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $user->username }}</p>
                        <p class="text-xs text-gray-500">Last active: {{ $user->last_active_at?->diffForHumans() ?? 'Unknown' }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>