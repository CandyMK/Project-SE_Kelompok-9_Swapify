<div>
    {{-- Care about people's approval and you will be their prisoner. --}}

    <div class="chatlist_header">

        <div class="title">
            Chat
        </div>

        <div class="img_container">
            @auth
                <img src="{{ auth()->user()->photo ? asset('storage/profile-photos/'.auth()->user()->photo) : asset('storage/profile-photos/default_photo.jpg') }}">
            @else
                <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=Guest" alt="">
            @endauth
        </div>
    </div>

    <div class="chatlist_body">

        @if (count($conversations) > 0)
            @foreach ($conversations as $conversation)
                <div class="m-2 flex flex-row flex-nowrap p-2 space-x-4 rounded-md bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-900 text-gray-800 dark:text-gray-200 hover:cursor-pointer"
                    wire:key='{{ $conversation->id }}'
                    wire:click="$emit('chatUserSelected', {{ $conversation }},{{ $this->getChatUserInstance($conversation, $name = 'id') }})">
                    <div class="chatlist_img_container">
                        <img src="{{ $this->getChatUserInstance($conversation, $name = 'photo') ? asset('storage/profile-photos/'.$this->getChatUserInstance($conversation, $name = 'photo')) : asset('storage/profile-photos/default_photo.jpg') }}"
                            alt="" class="rounded-full w-14 h-11 object-cover">
                    </div>

                    <div class="w-full pr-2">
                        <div class="flex flex-row justify-between">
                            <div class="list_username">{{ $this->getChatUserInstance($conversation, $name = 'username') }}
                            </div>
                            @php
                                $lastMessage = $conversation->messages->last();
                            @endphp

                            <span class="date">
                                {{ $lastMessage ? $lastMessage->created_at->shortAbsoluteDiffForHumans() : 'No messages yet' }}
                            </span>
                        </div>

                        <div class="bottom_row">

                            <div class="message_body text-truncate">
                                {{ $lastMessage ? $lastMessage->body : 'No message' }}
                            </div>
                            @php
                                if (count($conversation->messages->where('read', 0)->where('receiver_id', Auth()->user()->id))) {
                                    echo ' <div class="unread_count badge rounded-pill text-light bg-danger">  ' . count($conversation->messages->where('read', 0)->where('receiver_id', Auth()->user()->id)) . '</div> ';
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            you have no conversations
        @endif

    </div>
</div>
