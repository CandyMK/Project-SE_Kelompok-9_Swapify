// document.addEventListener('DOMContentLoaded', function () {
//     document.querySelectorAll('.like-btn').forEach(button => {
//         button.addEventListener('click', function () {
//             const serviceId = this.getAttribute('data-service-id');
//             const isLiked = this.getAttribute('data-liked') === 'true';
//             const btn = this;

//             fetch(`/services/${serviceId}/${isLiked ? 'unlike' : 'like'}`, {
//                 method: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                     'Accept': 'application/json',
//                     'Content-Type': 'application/json'
//                 },
//                 body: JSON.stringify({})
//             })
//             .then(res => {
//                 if (!res.ok) throw new Error('Failed to update like');
//                 return res.json(); // <-- hanya kalau controller return JSON
//             })
//             .then(data => {
//                 btn.setAttribute('data-liked', (!isLiked).toString());
//                 btn.classList.toggle('liked', !isLiked);
//                 const icon = btn.querySelector('i');
//                 icon.classList.toggle('fas', !isLiked);
//                 icon.classList.toggle('far', isLiked);
//             })
//             .catch(err => {
//                 console.error(err);
//                 alert('Failed to update like. Please try again.');
//             });
//         });
//     });
// });

document.addEventListener('DOMContentLoaded', function () {
    // --- Kode untuk Tombol Like/Unlike ---
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function () {
            const serviceId = this.getAttribute('data-service-id');
            const isLiked = this.getAttribute('data-liked') === 'true';
            const btn = this;

            fetch(`/services/${serviceId}/${isLiked ? 'unlike' : 'like'}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(res => {
                if (!res.ok) throw new Error('Failed to update like');
                return res.json();
            })
            .then(data => {
                btn.setAttribute('data-liked', (!isLiked).toString());
                btn.classList.toggle('liked', !isLiked);
                const icon = btn.querySelector('i');
                icon.classList.toggle('fas', !isLiked);
                icon.classList.toggle('far', isLiked);

                // Opsional: Jika Anda ingin me-refresh bagian rekomendasi secara otomatis
                // setelah like/unlike, dan Anda yakin itu karena caching/state yang perlu di-refresh:
                // window.location.reload();
                // Atau, jika menggunakan Livewire di dashboard:
                // Livewire.emit('refreshRecommendedServices'); // Anda perlu listener di Livewire component
            })
            .catch(err => {
                console.error(err);
                alert('Failed to update like. Please try again.');
            });
        });
    });

    // --- Kode untuk Tombol Chat (setChatPartner) ---
    // Fungsi ini dipanggil dari onclick di Blade
    // window.setChatPartner sudah didefinisikan di sini
    // dan akan tersedia secara global karena tidak di dalam scope DOMContentLoaded
    // atau bisa juga didefinisikan di luar DOMContentLoaded jika ingin lebih eksplisit global
});

// --- Definisi Fungsi setChatPartner (di luar DOMContentLoaded agar global) ---
// Ini akan dipanggil oleh onclick="setChatPartner(...)" dari Blade
window.setChatPartner = function(userId, username) {
    // Simpan informasi partner chat ke localStorage
    localStorage.setItem('chatPartnerId', userId);
    localStorage.setItem('chatPartnerUsername', username);

    // Redirect ke halaman chat
    // Pastikan route 'chat' Anda bisa menerima 'key' (yaitu recipient_id)
    window.location.href = `/chat/${userId}`; // Mengarahkan ke route Livewire chat/{key?}
};
