{{-- <div>
    @if ($selectedConversation)
        <div class="chatbox_header">

            <div class="return">
                <i class="bi bi-arrow-left"></i>
            </div>

            <div class="img_container">
                <img src="{{ $receiverInstance->photo ? asset('storage/profile-photos/'.$receiverInstance->photo) : asset('storage/profile-photos/default_photo.jpg') }}">
            </div>

            <div class="name ">
                {{ $receiverInstance->username }}
            </div>

            <div class="info">
                <div class="info_item">
                    <i class="bi bi-telephone-fill"></i>
                </div>

                <div class="info_item">
                    <i class="bi bi-image"></i>
                </div>

                <div class="info_item">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
            </div>
        </div>

        <div class="chatbox_body">
            @foreach ($messages as $message)
                <div class="msg_body  {{ auth()->id() == $message->sender_id ? 'msg_body_me bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' : 'msg_body_receiver' }}"
                    style="width:80%;max-width:80%;max-width:max-content">
                    {{ $message->body }}
                    <div class="msg_body_footer">
                        <div class="date">
                            {{ $message->created_at->format('m: i a') }}
                        </div>

                        <div class="read">
                            @php
                                if ($message->user->id === auth()->id()) {
                                    if ($message->read == 0) {
                                        echo '<i class="bi bi-check2 status_tick "></i> ';
                                    } else {
                                        echo '<i class="bi bi-check2-all text-primary  "></i> ';
                                    }
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <script>
            $(".chatbox_body").on('scroll', function() {
                var top = $('.chatbox_body').scrollTop();
                if (top == 0) {
                    window.livewire.emit('loadMore');
                }
            });
        </script>

        <script>
            window.addEventListener('updatedHeight', event => {
                let old = event.detail.height;
                let newHeight = $('.chatbox_body')[0].scrollHeight;
                let height = $('.chatbox_body').scrollTop(newHeight - old);
                window.livewire.emit('updateHeight', {
                    height: height,
                });
            });
        </script>
    @else
        <div class="fs-4 text-center text-primary mt-5">
            no conversasion selected
        </div>
    @endif

    <script>
        window.addEventListener('rowChatToBottom', event => {
            $('.chatbox_body').scrollTop($('.chatbox_body')[0].scrollHeight);
        });
    </script>

    <script>
        $(document).on('click', '.return', function() {
            window.livewire.emit('resetComponent');
        });
    </script>

    <script>
        window.addEventListener('markMessageAsRead', event => {
            var value = document.querySelectorAll('.status_tick');
            value.array.forEach(element, index => {
                element.classList.remove('bi bi-check2');
                element.classList.add('bi bi-check2-all', 'text-primary');
            });
        });
    </script>
</div>

 --}}

 {{-- resources/views/livewire/chat/chatbox.blade.php --}}
<div>
    @if ($selectedConversation)
        <div class="chatbox_header">
            <div class="return">
                <i class="bi bi-arrow-left"></i>
            </div>

            <div class="img_container">
                <img src="{{ $receiverInstance->photo ? asset('storage/profile-photos/'.$receiverInstance->photo) : asset('storage/profile-photos/default_photo.jpg') }}" alt="{{ $receiverInstance->username }}">
            </div>

            <div class="name ">
                {{ $receiverInstance->username }}
            </div>

            <div class="info">
                <div class="info_item">
                    <i class="bi bi-telephone-fill"></i>
                </div>
                <div class="info_item">
                    <i class="bi bi-image"></i>
                </div>
                <div class="info_item">
                    <i class="bi bi-info-circle-fill"></i>
                </div>
            </div>
        </div>

        {{-- Pastikan ID ada di sini untuk JavaScript --}}
        <div class="chatbox_body" id="chatbox_body">
            @foreach ($messages as $message)
                <div class="msg_body {{ auth()->id() == $message->sender_id ? 'msg_body_me bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' : 'msg_body_receiver' }}"
                    style="width:80%;max-width:80%;max-width:max-content">
                    {{ $message->body }}
                    <div class="msg_body_footer">
                        <div class="date">
                            {{ $message->created_at->format('H:i a') }} {{-- Format waktu yang lebih umum --}}
                        </div>
                        <div class="read">
                            @php
                                if ($message->sender_id === auth()->id()) {
                                    if ($message->read == 0) {
                                        echo '<i class="bi bi-check2 status_tick "></i> ';
                                    } else {
                                        echo '<i class="bi bi-check2-all text-primary "></i> ';
                                    }
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="fs-4 text-center text-black mt-5">
            no conversasion selected
        </div>
    @endif
</div>

{{-- Skrip JavaScript terpadu untuk auto-load dan interaksi Livewire --}}
@push('scripts')
<script>
    // Pastikan ini di dalam event listener Livewire Load
    document.addEventListener('livewire:load', function () {
        const chatboxBody = document.getElementById('chatbox_body'); // Dapatkan elemen sekali

        // Fungsi helper untuk scroll ke bawah
        function scrollToBottom() {
            if (chatboxBody) {
                chatboxBody.scrollTop = chatboxBody.scrollHeight;
            }
        }

        // 1. SCROLL KE BAWAH SAAT CHATBOX DIMUAT/UPDATE (untuk pesan baru)
        // Livewire hook ini dipicu setiap kali DOM komponen diperbarui
        Livewire.hook('element.updated', (el, component) => {
            // Pastikan ini komponen chatbox dan elemen chatbox_body
            if (component.name === 'chat.chatbox' && el.id === 'chatbox_body') {
                scrollToBottom();
            }
        });

        // 2. SCROLL KE BAWAH SAAT PESAN BARU DITAMBAHKAN (melalui pushMessage dari Livewire)
        window.addEventListener('rowChatToBottom', event => {
            scrollToBottom();
        });

        // 3. SCROLL KE BAWAH SAAT CHAT DIPILIH (dari chat-list)
        window.addEventListener('chatSelected', event => {
            // Beri sedikit waktu untuk Livewire me-render pesan-pesan awal
            setTimeout(scrollToBottom, 100);
        });

        // 4. LISTENER UNTUK LOAD MORE (jika ada)
        if (chatboxBody) { // Pastikan elemen ada sebelum menambahkan event listener
            chatboxBody.addEventListener('scroll', function() {
                if (chatboxBody.scrollTop === 0) {
                    window.livewire.emit('loadMore');
                }
            });
        }

        // 5. PENANGANAN UPDATE HEIGHT DARI LOAD MORE
        window.addEventListener('updatedHeight', event => {
            let oldScrollHeight = event.detail.height;
            let newScrollHeight = chatboxBody.scrollHeight; // Gunakan elemen yang sudah didapat
            chatboxBody.scrollTop = newScrollHeight - oldScrollHeight;
        });

        // 6. PENANGANAN MARK MESSAGE AS READ
        window.addEventListener('markMessageAsRead', event => {
            // Perbaiki iterasi array di JavaScript native
            document.querySelectorAll('.status_tick').forEach(element => {
                element.classList.remove('bi-check2');
                element.classList.add('bi-check2-all', 'text-primary');
            });
        });

        // 7. PENANGANAN TOMBOL KEMBALI (RETURN)
        // Menggunakan Vanilla JS listener untuk kejelasan, meskipun $(document).on juga bisa
        const returnButton = document.querySelector('.return');
        if (returnButton) {
            returnButton.addEventListener('click', function() {
                window.livewire.emitTo('chat.main', 'resetChatState');
                // Logika show/hide chat_list_container/chat_box_container biasanya
                // dikelola di parent Livewire component (Main) atau di event 'resetChatState'
                // atau langsung di JS ini jika Anda punya kontrol penuh atas display
                if (window.innerWidth < 768) { // Untuk mobile
                    // Asumsi .chat_list_container dan .chat_box_container ada di parent livewire/main.blade.php
                    // Jika elemen ini di luar scope Livewire, gunakan querySelectorAll
                    const chatListContainer = document.querySelector('.chat_list_container');
                    const chatBoxContainer = document.querySelector('.chat_box_container');
                    if (chatListContainer) chatListContainer.style.display = 'block';
                    if (chatBoxContainer) chatBoxContainer.style.display = 'none';
                }
            });
        }
    });
</script>
@endpush