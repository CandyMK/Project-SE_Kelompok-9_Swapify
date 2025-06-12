<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Foto Profil -->
        <div>
            <x-input-label for="photo" :value="__('Profile Photo')" />
            <x-text-input id="photo" name="photo" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="full_name" :value="__('Full Name')" />
            <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $user->full_name)" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Nomor Telepon -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full rounded-md shadow-sm">{{ old('bio', $user->bio ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- Portofolio -->
        <div>
            <x-input-label for="portfolio" :value="__('Portfolio (PDF)')" />
            <x-text-input id="portfolio" name="portfolio" type="file" accept="application/pdf" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('portfolio')" />
        </div>

        <!-- Lokasi -->
        <div>
            <x-input-label for="location" :value="__('Location (City or Address)')" />
            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $user->location ?? '')" />
            <x-input-error class="mt-2" :messages="$errors->get('location')" />
        </div>

        <!-- Sosial Media -->
        <div>
            <x-input-label for="instagram" :value="__('Instagram')" />
            <x-text-input id="instagram" name="instagram" type="url" class="mt-1 block w-full" :value="old('instagram', $user->instagram ?? '')" />
        </div>

        <div>
            <x-input-label for="facebook" :value="__('Facebook')" />
            <x-text-input id="facebook" name="facebook" type="url" class="mt-1 block w-full" :value="old('facebook', $user->facebook ?? '')" />
        </div>

        <div>
            <x-input-label for="twitter" :value="__('Twitter')" />
            <x-text-input id="twitter" name="twitter" type="url" class="mt-1 block w-full" :value="old('twitter', $user->twitter ?? '')" />
        </div>

        <!-- Rating dan Ulasan (Read-Only) -->
        <div>
            <x-input-label :value="__('Rating & Reviews')" />
            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                {{ $rating ?? 'No rating yet.' }} ★ ({{ $review_count ?? 0 }} Review)
            </p>
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>