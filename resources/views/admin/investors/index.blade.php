<x-layout title="Manage Investors">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-4">Commercial Registrations</h2>

                    <!-- Filters -->
                    <div class="mb-6">
                        <form method="GET" class="flex gap-4">
                            <select name="status" class="rounded-md border-gray-300">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Filter</button>
                        </form>
                    </div>

                    <!-- Registrations Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Investor
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Registration Number
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Submitted At
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($registrations as $registration)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $registration->user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $registration->user->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">
                                            {{ $registration->registration_number }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $registration->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $registration->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($registration->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $registration->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if ($registration->status == 'approved')

                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            bg-green-100 text-green-800">
                                            Approved
                                        </span>

                                        @else
                                        <button onclick="openModal('{{ $registration->id }}')"
                                                class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400">
                                            Review
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $registrations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    Update Registration Status
                </h3>
                <form id="updateForm" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300"
                                onchange="toggleRejectionReason()">
                            <option value="approved">Approve</option>
                            <option value="rejected">Reject</option>
                        </select>
                    </div>

                    <div id="rejectionReasonDiv" class="mb-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Rejection Reason
                        </label>
                        <textarea name="rejection_reason"
                                  class="mt-1 block w-full rounded-md border-gray-300"
                                  rows="3"></textarea>
                    </div>

                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="closeModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(registrationId) {
            document.getElementById('reviewModal').classList.remove('hidden');
            document.getElementById('updateForm').action = `/admin/investors/${registrationId}`;
        }

        function closeModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }

        function toggleRejectionReason() {
            const status = document.getElementById('status').value;
            const rejectionDiv = document.getElementById('rejectionReasonDiv');
            rejectionDiv.classList.toggle('hidden', status !== 'rejected');
        }
    </script>
    @endpush
</x-layout>
