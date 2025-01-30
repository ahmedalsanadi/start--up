@props(['user', 'routes'])

@php
    $unreadNotificationsCount = auth()->user()->unreadNotifications()->count();
@endphp
<aside id="logo-sidebar"
    class="fixed top-0 right-0 z-40 w-64 h-screen pt-24 transition-transform duration-300 ease-in-out translate-x-full bg-gray-100 border-l border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto">
        <ul class="space-y-1 text-md font-medium">
            @foreach ($routes as $route)
                <x-layout.sidebar-link :route="$route['route']" :icon="$route['icon']" :label="$route['label']"
                    :count="$route['count'] ?? null" />
            @endforeach

            <!-- Sidebar Notification Counter -->
            <li>
                <a href="{{ route('notifications.index') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i data-lucide="bell"
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">الإشعارات</span>
                    <span id="sidebar-notification-count" class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300
            {{ $unreadNotificationsCount > 0 ? '' : 'hidden' }}">
                        {{ $unreadNotificationsCount }}
                    </span>
                </a>
            </li>

        </ul>
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <!-- Profile -->
            <li>
                <a href="{{ route('profile.show', ['profile' => $user->id]) }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <i data-lucide="user"
                        class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">الملف الشخصي</span>
                </a>
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-right">
                        <div
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <i data-lucide="log-out"
                                class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">تسجيل الخروج</span>
                        </div>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>