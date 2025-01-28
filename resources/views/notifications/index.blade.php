<x-layout title="Notifications">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
        <!-- Page Header -->
        <div class="p-6 border-b dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">جميع الإشعارات</h2>
        </div>

        <!-- Notifications List -->
        <div class="p-6">
            @forelse($notifications as $notification)
                <div class="py-4 border-b dark:border-gray-700 last:border-b-0">
                    <div class="flex items-start gap-4">
                        <!-- Notification Icon -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/50 flex items-center justify-center">
                                <i data-lucide="bell" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                            </div>
                        </div>
                        <!-- Notification Content -->
                        <div class="flex-1">
                            <p class="text-lg font-medium text-gray-900 dark:text-white">
                                {{ $notification->data['title'] }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                {{ $notification->data['message'] }}
                            </p>
                            @if(isset($notification->data['action_url']))
                                <a href="{{ $notification->data['action_url'] }}"
                                    class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    عرض التفاصيل
                                </a>
                            @endif
                            <p class="text-xs text-gray-400 mt-2">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center">لا توجد إشعارات</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t dark:border-gray-700">
            {{ $notifications->links() }}
        </div>
    </div>

</x-layout>