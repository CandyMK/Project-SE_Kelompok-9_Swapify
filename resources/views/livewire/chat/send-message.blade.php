<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    @if ($selectedConversation)
        <form wire:submit.prevent='sendMessage' action="">
            <div class="chatbox_footer bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                <div class="custom_form_group bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200">
                    <input wire:model='body' type="text"
                        class="control bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                        placeholder="Write message">
                    <button type="submit" class="submit">Send</button>
                </div>

            </div>
        </form>
    @endif

</div>
