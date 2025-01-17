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
            <div class="flex gap-2">
                <form action="{{ route('admin.investor.updateStatus', $registration) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    <button type="submit"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-800 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        تأكيد
                    </button>
                </form>
                <form action="{{ route('admin.investor.updateStatus', $registration) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        رفض
                    </button>
                </form>
            </div>
        </div>
    </div>
</li>
