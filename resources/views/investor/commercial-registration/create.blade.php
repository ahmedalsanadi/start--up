<x-layout title="Commercial Registration">
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4">
        <div class="w-full max-w-2xl">
            <form method="POST" action="{{ route('commercial-registration.store') }}" class="form-container">
                @csrf
                <div class="space-y-6">
                    <div class="text-center">
                        <h2 class="form-title">Commercial Registration Details</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Please provide your commercial registration information to continue</p>
                    </div>

                    <!-- Registration Number -->
                    <div class="form-group">
                        <label for="registration_number" class="form-label">Commercial Registration Number</label>
                        <input
                            type="text"
                            id="registration_number"
                            name="registration_number"
                            value="{{ old('registration_number') }}"
                            class="form-input"
                            placeholder="Enter your commercial registration number"
                            required
                        >
                        @error('registration_number')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Registration Number -->
                    <div class="form-group">
                        <label for="registration_number_confirmation" class="form-label">Confirm Registration Number</label>
                        <input
                            type="text"
                            id="registration_number_confirmation"
                            name="registration_number_confirmation"
                            class="form-input"
                            placeholder="Confirm your commercial registration number"
                            required
                        >
                        @error('registration_number_confirmation')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" class="btn-primary w-full">
                            Submit Registration
                        </button>
                    </div>

                    <!-- Information Note -->
                    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    Your registration will be reviewed by our admin team. You'll be notified once your registration is approved.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
