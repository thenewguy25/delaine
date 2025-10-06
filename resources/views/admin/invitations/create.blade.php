<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Send Invitation') }}
            </h2>
            <a href="{{ route('admin.invitations.index') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Invitations') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.invitations.store') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autocomplete="email" placeholder="user@example.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-600">
                                The invitation will be sent to this email address.
                            </p>
                        </div>

                        <!-- Invitation Type -->
                        <div class="mb-6">
                            <x-input-label for="invitation_type" :value="__('Invitation Type')" />
                            <select id="invitation_type" name="invitation_type"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <option value="">Select Type</option>
                                <option value="user" {{ old('invitation_type') === 'user' ? 'selected' : '' }}>User
                                </option>
                                <option value="admin" {{ old('invitation_type') === 'admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="custom" {{ old('invitation_type') === 'custom' ? 'selected' : '' }}>Custom
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('invitation_type')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-600">
                                Choose the type of invitation to send.
                            </p>
                        </div>

                        <!-- Role Assignment -->
                        <div class="mb-6">
                            <x-input-label for="role" :value="__('Role Assignment')" />
                            <select id="role" name="role"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Use Default Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-600">
                                Optional: Assign a specific role. If not selected, the default role will be used.
                            </p>
                        </div>

                        <!-- Invitation Details -->
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                            <h3 class="text-sm font-medium text-blue-800 mb-2">Invitation Details</h3>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Invitation will expire in {{ config('registration.invitation_expiry_hours', 72) }}
                                    hours</li>
                                <li>• User will receive an email with registration link</li>
                                <li>• Email address must be unique (not already registered)</li>
                                <li>• Invitation can be resent or extended if needed</li>
                            </ul>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.invitations.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button>
                                {{ __('Send Invitation') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>