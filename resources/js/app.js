import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import '../css/chat.css';

import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

console.log(window.userId);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    // Jika perlu autentikasi private channel
    auth: {
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    }
});

window.Echo.private('chat.' + window.userId)
    .listen('.message.sent', (e) => {
        console.log('Pesan masuk:', e);
        Livewire.dispatch('incomingMessage', { messageId: e.message });
    });
