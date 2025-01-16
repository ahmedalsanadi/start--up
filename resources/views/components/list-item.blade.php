@props(['user', 'registration'])

<li>
    <div class="px-4 py-4 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img class="h-12 w-12 rounded-full"
                    src="{{ filter_var($user->profile_image, FILTER_VALIDATE_URL) ? $user->profile_image : asset('storage/' . $user->profile_image ?? '/default-avatar.jpg') }}"
                    alt="">
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->name }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $registration->registration_number }}
                    </div>
                </div>
            </div>
            <div class="flex space-x-2">
                <x-button action="{{ route('admin.investor.updateStatus', $registration) }}" method="POST" status="approved" color="green">
                    Approve
                </x-button>
                <x-button action="{{ route('admin.investor.updateStatus', $registration) }}" method="POST" status="rejected" color="red">
                    Reject
                </x-button>
            </div>
        </div>
    </div>
</li>
