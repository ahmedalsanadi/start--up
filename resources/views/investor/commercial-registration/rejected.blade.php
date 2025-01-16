<x-layout title="Registration Rejected">
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4">
        <div class="w-full max-w-2xl p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="text-center">
                <!-- Rejected Icon -->
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100 dark:bg-red-900/30">
                    <svg class="h-12 w-12 text-red-600 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>

                <!-- Status Message -->
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                    Registration Rejected
                </h2>

                <div class="mt-4 space-y-4">
                    <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        <p class="text-red-700 dark:text-red-400">
                            {{ $reason }}
                        </p>
                    </div>

                    <p class="text-gray-600 dark:text-gray-400">
                        Please review the rejection reason and submit a new commercial registration number.
                    </p>

                    <!-- Resubmission Form -->
                    <form method="POST" action="{{ route('commercial-registration.store') }}" class="mt-8 space-y-6">
                        @csrf
                        <div>
                            <label for="registration_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                New Commercial Registration Number
                            </label>
                            <input type="text" name="registration_number" id="registration_number" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="registration_number_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Confirm Registration Number
                            </label>
                            <input type="text" name="registration_number_confirmation" id="registration_number_confirmation" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Submit New Registration
                        </button>
                    </form>

                    <!-- Logout Option -->
                    <div class="mt-6">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
