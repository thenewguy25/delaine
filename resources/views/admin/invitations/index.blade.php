<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Invitation Management') }}
            </h2>
            <a href="{{ route('admin.invitations.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Send Invitation') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.invitations.index') }}" class="flex flex-wrap gap-4">
                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired
                                </option>
                                <option value="used" {{ request('status') === 'used' ? 'selected' : '' }}>Used</option>
                                <option value="unused" {{ request('status') === 'unused' ? 'selected' : '' }}>Unused
                                </option>
                            </select>
                        </div>

                        <!-- Type Filter -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Types</option>
                                <option value="admin" {{ request('type') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ request('type') === 'user' ? 'selected' : '' }}>User</option>
                                <option value="custom" {{ request('type') === 'custom' ? 'selected' : '' }}>Custom
                                </option>
                            </select>
                        </div>

                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search Email</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Search by email..."
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                            <a href="{{ route('admin.invitations.index') }}"
                                class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Bulk Action Controls -->
                    <form id="bulk-form" method="POST" action="{{ route('admin.invitations.bulk-action') }}">
                        @csrf
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-4">
                                <input type="checkbox" id="select-all"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <label for="select-all" class="text-sm font-medium text-gray-700">Select All</label>

                                <select name="action" id="bulk-action"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="">Bulk Actions</option>
                                    <option value="delete">Delete Selected</option>
                                    <option value="extend">Extend Expiry</option>
                                </select>

                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Execute
                                </button>
                            </div>
                        </div>

                        <!-- Invitations Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <input type="checkbox" id="select-all-checkbox"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Created By</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Expires</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($invitations as $invitation)
                                                                    <tr
                                                                        class="{{ $invitation->isExpired() ? 'bg-red-50' : ($invitation->isUsed() ? 'bg-green-50' : '') }}">
                                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                                            <input type="checkbox" name="invitations[]" value="{{ $invitation->id }}"
                                                                                class="invitation-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                                        </td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                            {{ $invitation->email }}
                                                                        </td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                            <span
                                                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                                                                                                                                                                                                                                                                    {{ $invitation->invitation_type === 'admin' ? 'bg-red-100 text-red-800' :
                                        ($invitation->invitation_type === 'user' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                                                {{ ucfirst($invitation->invitation_type) }}
                                                                            </span>
                                                                        </td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                            {{ $invitation->role ?? 'Default' }}
                                                                        </td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                            @if($invitation->isUsed())
                                                                                <span
                                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                                    Used
                                                                                </span>
                                                                            @elseif($invitation->isExpired())
                                                                                <span
                                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                                    Expired
                                                                                </span>
                                                                            @else
                                                                                <span
                                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                                                    Active
                                                                                </span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                            {{ $invitation->creator->name }}
                                                                        </td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                            {{ $invitation->expires_at->format('M d, Y H:i') }}
                                                                        </td>
                                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                            <div class="flex space-x-2">
                                                                                <a href="{{ route('admin.invitations.show', $invitation) }}"
                                                                                    class="text-indigo-600 hover:text-indigo-900">View</a>

                                                                                @if(!$invitation->isUsed())
                                                                                    <a href="{{ route('admin.invitations.edit', $invitation) }}"
                                                                                        class="text-blue-600 hover:text-blue-900">Edit</a>

                                                                                    <button type="button"
                                                                                        class="text-green-600 hover:text-green-900 resend-btn"
                                                                                        data-invitation-id="{{ $invitation->id }}"
                                                                                        onclick="resendInvitation({{ $invitation->id }})">Resend</button>

                                                                                    <button type="button"
                                                                                        class="text-yellow-600 hover:text-yellow-900 extend-btn"
                                                                                        data-invitation-id="{{ $invitation->id }}"
                                                                                        onclick="extendInvitation({{ $invitation->id }})">Extend</button>
                                                                                @endif

                                                                                <button type="button" class="text-red-600 hover:text-red-900 delete-btn"
                                                                                    data-invitation-id="{{ $invitation->id }}"
                                                                                    onclick="deleteInvitation({{ $invitation->id }})">Delete</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                                No invitations found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $invitations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select all functionality
        document.getElementById('select-all-checkbox').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('.invitation-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Individual checkbox change
        document.querySelectorAll('.invitation-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const allCheckboxes = document.querySelectorAll('.invitation-checkbox');
                const checkedCheckboxes = document.querySelectorAll('.invitation-checkbox:checked');
                document.getElementById('select-all-checkbox').checked = allCheckboxes.length === checkedCheckboxes.length;
            });
        });

        // Prevent bulk form from interfering with individual forms
        document.getElementById('bulk-form').addEventListener('submit', function (e) {
            // Only submit if action is selected
            const action = document.getElementById('bulk-action').value;
            if (!action) {
                e.preventDefault();
                alert('Please select a bulk action first.');
                return false;
            }
        });

        // CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            document.querySelector('input[name="_token"]')?.value;

        // Resend invitation function
        function resendInvitation(invitationId) {
            console.log('Resending invitation:', invitationId);

            fetch(`/admin/invitations/${invitationId}/resend`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
                .then(response => {
                    if (response.ok) {
                        alert('Invitation email resent successfully!');
                        location.reload(); // Refresh to show updated status
                    } else {
                        alert('Failed to resend invitation. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while resending the invitation.');
                });
        }

        // Extend invitation function
        function extendInvitation(invitationId) {
            console.log('Extending invitation:', invitationId);

            fetch(`/admin/invitations/${invitationId}/extend`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({})
            })
                .then(response => {
                    if (response.ok) {
                        alert('Invitation expiry date extended successfully!');
                        location.reload(); // Refresh to show updated expiry
                    } else {
                        alert('Failed to extend invitation. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while extending the invitation.');
                });
        }

        // Delete invitation function
        function deleteInvitation(invitationId) {
            if (!confirm('Are you sure you want to delete this invitation?')) {
                return;
            }

            console.log('Deleting invitation:', invitationId);

            fetch(`/admin/invitations/${invitationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        alert('Invitation deleted successfully!');
                        location.reload(); // Refresh to remove the row
                    } else {
                        alert('Failed to delete invitation. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the invitation.');
                });
        }
    </script>
</x-app-layout>