@props(['user', 'registration'])

<li>
    <div class="px-4 py-4 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img class="h-12 w-12 rounded-full"
                    src="{{ filter_var($user->profile_image, FILTER_VALIDATE_URL) ? $user->profile_image : asset('storage/' . $user->profile_image ?? '/default-avatar.jpg') }}"
                    alt="">
                <div class="mr-4">
                    <div class="text-sm font-medium text-gray-950 dark:text-white">
                        {{ $user->name }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $registration->registration_number }}
                    </div>
                </div>
            </div>
            <div>
                @if ($registration->status == 'approved')
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        مقبول
                    </span>
                @else
                    <button onclick="openModal('{{ $registration->id }}')"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-800 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">

                        مراجعة
                    </button>
                @endif
            </div>
        </div>
    </div>
</li>

<x-commericial-review-modal />
