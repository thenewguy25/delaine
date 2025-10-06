<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invitation Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.invitations.edit', $invitation) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('admin.invitations.index') }}"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Invitations') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Invitation Status -->
                    <div class="mb-6">
                        @if($invitation->isUsed())
                            <div class="p-4 bg-green-50 border border-green-200 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">
                                            Invitation Used
                                        </h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>This invitation was used on {{ $invitation->used_at->format('M d, Y H:i') }}.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($invitation->isExpired())
                            <div class="p-4 bg-red-50 border border-red-200 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">
                                            Invitation Expired
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>This invitation expired on
                                                {{ $invitation->expires_at->format('M d, Y H:i') }}.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">
                                            Invitation Active
                                        </h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>This invitation is active and expires on
                                                {{ $invitation->expires_at->format('M d, Y H:i') }}.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Invitation Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $invitation->email }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Invitation Type</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $invitation->invitation_type === 'admin' ? 'bg-red-100 text-red-800' :
    ($invitation->invitation_type === 'user' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($invitation->invitation_type) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Assigned Role</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $invitation->role ?? 'Default Role' }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Token</dt>
                                    <dd class="mt-1 text-sm text-gray-900 font-mono bg-gray-100 p-2 rounded">
                                        {{ $invitation->token }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Timeline Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Timeline</h3>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $invitation->created_at->format('M d, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Expires</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $invitation->expires_at->format('M d, Y H:i') }}
                                    </dd>
                                </div>
                                @if($invitation->used_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Used</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $invitation->used_at->format('M d, Y H:i') }}
                                        </dd>
                                    </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created By</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $invitation->creator->name }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Registration Link -->
                    <div class="mt-8 p-4 bg-gray-50 border border-gray-200 rounded-md">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Registration Link</h3>
                        <div class="flex items-center space-x-2">
                            <input type="text"
                                value="{{ route('register', ['token' => $invitation->token, 'email' => $invitation->email]) }}"
                                readonly
                                class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <button onclick="copyToClipboard(this.previousElementSibling)"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Copy
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-600">
                            Share this link with the invited user to complete their registration.
                        </p>
                    </div>

                    <!-- Actions -->
                    @if(!$invitation->isUsed())
                        <div class="mt-8 flex space-x-4">
                            <form method="POST" action="{{ route('admin.invitations.resend', $invitation) }}"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Resend Email') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.invitations.extend', $invitation) }}"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Extend Expiry') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.invitations.destroy', $invitation) }}"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                    onclick="return confirm('Are you sure you want to delete this invitation?')">
                                    {{ __('Delete Invitation') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(element) {
            element.select();
            element.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand('copy');

            // Show feedback
            const button = element.nextElementSibling;
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            button.classList.add('bg-green-500', 'hover:bg-green-700');
            button.classList.remove('bg-blue-500', 'hover:bg-blue-700');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-500', 'hover:bg-green-700');
                button.classList.add('bg-blue-500', 'hover:bg-blue-700');
            }, 2000);
        }
    </script>
</x-app-layout>