{{-- <nav x-data="{ open: false }" class="bg-gray-100 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="#" class="navbar-logo">Swap<span>ify</span>.</a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('seeker-dashboard')" :active="request()->routeIs('seeker-dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('chat')" :active="request()->routeIs('chat')">
                        {{ __('Chat') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('users')" :active="request()->routeIs('users')">
                        {{ __('Users') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div class="px-4 flex items-center space-x-3">
                                <img src="{{ asset('storage/profile-photos/' . Auth::user()->photo) }}" alt="Profile Photo" class="w-10 h-10 rounded-full object-cover" />
                                <div>
                                    <div class="font-medium text-base text-gray-800 dark:text-gray-200" id="current-chat-user">
                                        {{ Auth::user()->username }}
                                    </div>
                                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gray-200 dark:hover:bg-gray-700">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Your Services Link -->
                        <x-dropdown-link :href="route('services.index')" class="hover:bg-gray-200 dark:hover:bg-gray-700">
                            {{ __('Your Services') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                class="hover:bg-gray-200 dark:hover:bg-gray-700"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('seeker-dashboard')" :active="request()->routeIs('seeker-dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <!-- Your Services Link for Mobile -->
            <x-responsive-nav-link :href="route('services.index')">
                {{ __('Your Services') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <img src="{{ Auth::user()->photo ? asset('storage/profile-photos/' . Auth::user()->photo) : asset('storage/profile-photos/default_photo.jpg') }}" 
                    alt="Profile Photo" 
                    class="w-10 h-10 rounded-full object-cover" />
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->username }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('livewire:load', function() {
        Livewire.on('updateNavbar', (user) => {
            document.getElementById('current-chat-user').textContent = user.username;
            // Update foto juga jika diperlukan
            document.querySelector('.profile-photo').src = user.photo 
                ? '/storage/profile-photos/' + user.photo 
                : '/storage/profile-photos/default_photo.jpg';
        });
    });
</script> --}}

{{-- layouts/navigation.blade.php --}}

<nav x-data="{ open: false }" class="bg-gray-900 dark:bg-black border-b border-white dark:border-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="#" class="navbar-logo">Swap<span>ify</span></a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('seeker-dashboard')" :active="request()->routeIs('seeker-dashboard')" 
                        class="text-gray-300 dark:text-gray-200 hover:text-white dark:hover:text-white 
                            {{ request()->routeIs('seeker-dashboard') ? 'border-b-2 border-white text-white' : '' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('chat')" :active="request()->routeIs('chat')"
                        class="text-gray-300 dark:text-gray-200 hover:text-white dark:hover:text-white
                               {{ request()->routeIs('chat') ? 'border-b-2 border-white text-white' : '' }}">
                        <span id="navbar-chat-link-text">{{ __('Chat') }}</span>
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('about-us')" :active="request()->routeIs('about-us')"
                        class="text-gray-300 dark:text-gray-200 hover:text-white dark:hover:text-white
                               {{ request()->routeIs('about-us') ? 'border-b-2 border-white text-white' : '' }}">
                        {{ __('About Us') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('contact-us')" :active="request()->routeIs('contact-us')"
                        class="text-gray-300 dark:text-gray-200 hover:text-white dark:hover:text-white
                               {{ request()->routeIs('contact-us') ? 'border-b-2 border-white text-white' : '' }}">
                        {{ __('Contact Us') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-300 dark:text-gray-100 bg-gray-900 dark:bg-black hover:text-white dark:hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <div class="px-4 flex items-center space-x-3">
                                {{-- Pastikan path photo profil benar, tambahkan default --}}
                                <img src="{{ Auth::user()->photo ? asset('storage/profile-photos/' . Auth::user()->photo) : asset('storage/profile-photos/default_photo.jpg') }}" alt="Profile Photo" class="w-10 h-10 rounded-full object-cover profile-photo" /> {{-- Tambahkan class profile-photo --}}
                                <div>
                                    <div class="font-medium text-base text-gray-100 dark:text-gray-50" id="current-chat-user">
                                        {{ Auth::user()->username }}
                                    </div>
                                    <div class="font-medium text-sm text-gray-300 dark:text-gray-300">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-gray-200 dark:hover:bg-gray-700">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('services.index')" class="hover:bg-gray-200 dark:hover:bg-gray-700">
                            {{ __('Your Services') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                class="hover:bg-gray-200 dark:hover:bg-gray-700"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('seeker-dashboard')" :active="request()->routeIs('seeker-dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('services.index')">
                {{ __('Your Services') }}
            </x-responsive-nav-link>

            {{-- Tambahkan link chat responsif untuk mobile --}}
            <x-responsive-nav-link :href="route('chat')">
                <span id="responsive-navbar-chat-link-text">{{ __('Chat') }}</span> {{-- Tambahkan ID di sini --}}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <img src="{{ Auth::user()->photo ? asset('storage/profile-photos/' . Auth::user()->photo) : asset('storage/profile-photos/default_photo.jpg') }}" 
                    alt="Profile Photo" 
                    class="w-10 h-10 rounded-full object-cover" />
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->username }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>