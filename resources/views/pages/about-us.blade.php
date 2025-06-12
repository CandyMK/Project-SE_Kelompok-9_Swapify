{{-- resources/views/pages/about-us.blade.php --}}
<x-app-layout>
    <div class="min-h-screen bg-white-900 dark:bg-black text-gray-200 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-center mb-12">
                <span class="text-black dark:text-black font-extrabold">About</span> {{-- Kata "About" akan hitam --}}
                <span class="text-gray-500 dark:text-gray-500 font-extrabold">Us</span>   {{-- Kata "Us" akan abu-abu --}}
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="flex justify-center md:justify-center"> 
                    <img src="{{ asset('storage/logo/swapify-removebg-preview.png') }}" alt="Swapify Logo" class="w-64 md:w-80 lg:w-96">
                </div>
                
                {{-- Kolom Kanan: Teks --}}
                <div>
                    {{-- Pastikan teksnya juga putih untuk tema gelap --}}
                    <h2 class="text-2xl sm:text-3xl font-bold mb-4 text-black dark:text-white">What is Swapify?</h2>
                    <p class="mb-4 leading-relaxed text-black dark:text-black-200">
                        Swapify is a platform where people connect and grow by exchanging their skills and services.
                        Whether you're a designer, writer, developer, teacher, or offer any other type of service,
                        Swapify helps you find others with different expertise so you can collaborate and support each other.
                    </p>
                    <p class="leading-relaxed text-black dark:text-black-200">
                        Our goal is to make it easier for everyone to explore new opportunities, learn new things,
                        and build meaningful connections across different fields. With a wide range of categories
                        and users from all backgrounds, Swapify makes skill-swapping simple, flexible, and rewarding.
                    </p>
                    <p class="mt-4 leading-relaxed font-semibold text-black dark:text-gray-200">
                        Discover what you can do — and what others can do for you — with Swapify.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>