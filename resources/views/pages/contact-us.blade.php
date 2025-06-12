{{-- resources/views/pages/contact-us.blade.php --}}
<x-app-layout>
    <div class="min-h-screen bg-white dark:bg-black text-gray-200 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
             <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-center mb-12">
                <span class="text-black dark:text-black font-extrabold">Contact</span> 
                <span class="text-gray-500 dark:text-gray-500 font-extrabold">Us</span>   
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                {{-- Bagian Kiri: Peta (Contoh Google Maps Embed) --}}
                <div>
                    <p class="text-black sm:text-2xl font-bold mb-4">Our location</p>
                    <div class="bg-gray-800 dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden h-96 w-full">
                        {{-- Google Maps Embed (Ganti URL dengan lokasi Anda) --}}
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15957.51906915004!2d116.8920197!3d-1.2612711!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2b5b1a6c1e1e1e1e%3A0x1e1e1e1e1e1e1e1e!2sBandung%20City%20Hall!5e0!3m2!1sen!2sid!4v1678888888888!5m2!1sen!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                {{-- Bagian Kanan: Formulir Kontak --}}
                <div class="bg-black dark:bg-gray-900 p-8 rounded-lg shadow-lg">
                    <form id="contactForm" action="{{ route('contact-us.submit') }}" method="POST"> {{-- Ganti '#' dengan route untuk submit form kontak Anda --}}
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" id="name" name="name" placeholder="Name"
                                class="w-full px-4 py-3 rounded-lg bg-gray-400 dark:bg-gray-800 text-black placeholder-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" id="email" name="email" placeholder="Email"
                                class="w-full px-4 py-3 rounded-lg bg-gray-400 dark:bg-gray-800 text-black placeholder-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-6">
                            <label for="phone" class="sr-only">Phone</label>
                            <input type="text" id="phone" name="phone" placeholder="Phone Number"
                                class="w-full px-4 py-3 rounded-lg bg-gray-400 dark:bg-gray-800 text-black placeholder-black focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="mb-6"> 
                            <label for="message" class="sr-only">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="Message"
                                class="w-full px-4 py-3 rounded-lg bg-gray-400 dark:bg-gray-800 text-black placeholder-black focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-white hover:bg-gray-600 text-black font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Container untuk Pop-up Notifikasi --}}
    <div id="notification-overlay" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-start pt-12 z-[1000] hidden opacity-0 transition-opacity duration-300">
        <div id="notification-dialog" class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl p-8 max-w-sm w-full transform -translate-y-full transition-transform duration-500 ease-out">
            <div class="flex items-center mb-4">
                <svg id="notification-icon-success" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <svg id="notification-icon-error" class="h-6 w-6 text-red-500 mr-2 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 id="notification-title" class="text-xl font-semibold text-gray-900 dark:text-gray-100">Success!</h3>
            </div>
            <p id="notification-message" class="text-gray-700 dark:text-gray-300">Your message has been sent successfully.</p>
            <div class="flex justify-end mt-4">
                <button id="close-notification" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Close</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.getElementById('contactForm');
            const notificationOverlay = document.getElementById('notification-overlay');
            const notificationDialog = document.getElementById('notification-dialog');
            const notificationIconSuccess = document.getElementById('notification-icon-success');
            const notificationIconError = document.getElementById('notification-icon-error');
            const notificationTitle = document.getElementById('notification-title');
            const notificationMessage = document.getElementById('notification-message');
            const closeNotificationButton = document.getElementById('close-notification');

            function showNotification(isSuccess, title, message) {
                // Set icon and title
                if (isSuccess) {
                    notificationIconSuccess.classList.remove('hidden');
                    notificationIconError.classList.add('hidden');
                    notificationTitle.textContent = title || 'Success!';
                } else {
                    notificationIconSuccess.classList.add('hidden');
                    notificationIconError.classList.remove('hidden');
                    notificationTitle.textContent = title || 'Error!';
                }
                notificationMessage.textContent = message;

                // Show overlay and dialog
                notificationOverlay.classList.remove('hidden');
                setTimeout(() => { // Allow hidden class to be removed before starting opacity transition
                    notificationOverlay.classList.add('opacity-100');
                    notificationDialog.classList.remove('-translate-y-full'); // Move dialog into view
                }, 10); // A small delay is sometimes needed for transition to apply

                // Auto-hide after a few seconds, or keep it open if it's an error
                if (isSuccess) {
                    setTimeout(hideNotification, 3000); // Hide success message after 3 seconds
                } else {
                    // For errors, allow user to close manually or show for longer
                    // setTimeout(hideNotification, 5000); // Example: hide error after 5 seconds
                }
            }

            function hideNotification() {
                notificationOverlay.classList.remove('opacity-100');
                notificationDialog.classList.add('-translate-y-full');
                setTimeout(() => {
                    notificationOverlay.classList.add('hidden');
                }, 500); // Wait for transform transition to complete before hiding
            }

            // Close button listener
            closeNotificationButton.addEventListener('click', hideNotification);

            if (contactForm) {
                contactForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const formData = new FormData(contactForm);
                    const formProps = Object.fromEntries(formData);

                    fetch(contactForm.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(formProps)
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw err; });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showNotification(true, 'Message Sent!', data.message);
                            contactForm.reset(); // Kosongkan formulir
                        } else {
                            showNotification(false, 'Submission Failed!', data.message || 'An unknown error occurred.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        let errorMessage = 'Failed to send message. Please check your input and try again.';
                        if (error.errors) { // Error validasi Laravel
                            errorMessage = Object.values(error.errors).flat().join('\n');
                        } else if (error.message) {
                            errorMessage = error.message;
                        }
                        showNotification(false, 'Error', errorMessage);
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>