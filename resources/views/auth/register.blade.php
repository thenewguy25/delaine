<x-guest-layout>
    <!-- Invitation Notice -->
    @if($invitation)
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        You've been invited!
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>You're registering with an invitation for <strong>{{ $invitation->email }}</strong></p>
                        @if($invitation->role)
                            <p class="mt-1">You'll be assigned the <strong>{{ $invitation->role }}</strong> role.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Hidden invitation fields -->
        @if($invitation)
            <input type="hidden" name="invitation_token" value="{{ request('token') }}">
            <input type="hidden" name="invitation_email" value="{{ $invitation->email }}">
            <input type="hidden" name="email" value="{{ $invitation->email }}">
        @endif

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $invitation?->email)" required autocomplete="username" :disabled="$invitation && $invitation->email" />
            @if($invitation && $invitation->email)
                <p class="mt-1 text-sm text-gray-600">Email is pre-filled from your invitation.</p>
            @endif
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Invitation-specific errors -->
        @if($errors->has('invitation_token'))
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                <div class="text-sm text-red-700">
                    {{ $errors->first('invitation_token') }}
                </div>
            </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ $invitation ? __('Complete Registration') : __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>