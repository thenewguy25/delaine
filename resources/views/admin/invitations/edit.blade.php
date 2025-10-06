<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Invitation') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.invitations.show', $invitation) }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('View Invitation') }}
                </a>
                <a href="{{ route('admin.invitations.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Invitations') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.invitations.update', $invitation) }}">
                        @csrf
                        @method('PUT')

                        <!-- Email Address -->
                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email', $invitation->email)" required autocomplete="email"
                                placeholder="user@example.com" />
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
                                <option value="user" {{ old('invitation_type', $invitation->invitation_type) === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('invitation_type', $invitation->invitation_type) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="custom" {{ old('invitation_type', $invitation->invitation_type) === 'custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                            <x-input-error :messages="$errors->get('invitation_type')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-600">
                                Choose the type of invitation.
                            </p>
                        </div>

                        <!-- Role Assignment -->
                        <div class="mb-6">
                            <x-input-label for="role" :value="__('Role Assignment')" />
                            <select id="role" name="role"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Use Default Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role', $invitation->role) === $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-600">
                                Optional: Assign a specific role. If not selected, the default role will be used.
                            </p>
                        </div>

                        <!-- Expiry Date -->
                        <div class="mb-6">
                            <x-input-label for="expires_at" :value="__('Expiry Date')" />
                            <x-text-input id="expires_at" class="block mt-1 w-full" type="datetime-local"
                                name="expires_at" :value="old('expires_at', $invitation->expires_at ? $invitation->expires_at->format('Y-m-d\TH:i') : '')" required />
                            <x-input-error :messages="$errors->get('expires_at')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-600">
                                When this invitation will expire. Must be in the future.
                            </p>
                        </div>

                        <!-- Current Status -->
                        <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-md">
                            <h3 class="text-sm font-medium text-gray-900 mb-2">Current Status</h3>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>Created:</strong> {{ $invitation->created_at->format('M d, Y H:i') }}</p>
                                <p><strong>Created By:</strong> {{ $invitation->creator->name }}</p>
                                <p><strong>Token:</strong> <span
                                        class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $invitation->token }}</span>
                                </p>
                                @if($invitation->used_at)
                                    <p><strong>Used:</strong> {{ $invitation->used_at->format('M d, Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.invitations.show', $invitation) }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                {{ __('Cancel') }}
                            </a>

                            <x-primary-button>
                                {{ __('Update Invitation') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>