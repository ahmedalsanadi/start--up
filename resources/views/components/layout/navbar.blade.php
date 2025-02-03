@php
    $user = Auth::user();
    $notifications = auth()->user()->notifications()->latest()->take(5)->get();
    $unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<nav class="fixed top-0 z-50 w-full border-b bg-gray-100 border-gray-200 dark:bg-gray-800 dark:border-gray-700 transition-colors duration-300 ease-in-out"
    dir="rtl">
    <div class="px-3 py-1 lg:px-5 lg:pr-3">
        <div class="flex items-center justify-between h-14">
            <!-- Mobile Sidebar Button -->
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">فتح القائمة الجانبية</span>
                <!-- Lucide Icon: Menu -->
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>

            <!-- Logo Section -->
            <div class="flex-shrink-0">
                <a href="{{ route('welcome') }}" class="flex items-center">
                    <img src="/logo.png" alt="StartBox" class="h-32 w-auto object-contain"> <!-- Adjusted height -->
                </a>
            </div>

            <!-- Right-Aligned Menu (Theme, Notifications, Profile) -->
            <div class="flex items-center gap-4">
                <x-theme-toggle />
                @auth

                    <!-- Notifications Dropdown (Always Visible) -->
                    <div class="relative">
                        <button id="notification-bell" type="button"
                            class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5"
                            data-dropdown-toggle="dropdown-notifications">
                            <!-- Lucide Icon: Bell -->
                            <i data-lucide="bell" class="w-6 h-6"></i>
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-600 rounded-full {{ $unreadCount === 0 ? 'hidden' : '' }}">
                                {{ $unreadCount }}
                            </span>
                        </button>
                        <!-- Notification Dropdown Content -->
                        <div class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl dark:bg-gray-700"
                            id="dropdown-notifications">
                            <div class="p-4 max-h-80 overflow-y-auto">
                                @forelse($notifications as $notification)
                                    <div class="py-3 notification-item {{ $notification->read_at ? 'opacity-75' : '' }}">
                                        <div class="flex items-start gap-3">
                                            <!-- Notification Icon -->
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/50 flex items-center justify-center">
                                                    <i data-lucide="bell" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                                </div>
                                            </div>
                                            <!-- Notification Content -->
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $notification->data['title'] }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $notification->data['message'] }}
                                                </p>
                                                @if(isset($notification->data['action_url']))
                                                    <a href="{{ $notification->data['action_url'] }}"
                                                        class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 notification-link"
                                                        data-notification-id="{{ $notification->id }}">
                                                        عرض التفاصيل
                                                    </a>
                                                @endif
                                                <p class="text-xs text-gray-400 mt-2">
                                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                </p>
                                            </div>
                                            <!-- Unread Indicator -->
                                            @unless($notification->read_at)
                                                <div class="w-2 h-2 bg-blue-600 rounded-full notification-unread-indicator"></div>
                                            @endunless
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400 text-center">لا توجد إشعارات</p>
                                @endforelse
                            </div>



                            <!-- View All Notifications Link -->
                            @if ($user->isInvestor() && !$user->hasApprovedRegistration())

                            @else

                                <div class="border-t border-gray-200 dark:border-gray-600">
                                    <a href="{{ route('notifications.index') }}"
                                        class="block py-2 text-sm font-medium text-center text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-600">
                                        عرض جميع الإشعارات
                                    </a>
                                </div>

                            @endif
                        </div>
                    </div>
                @endauth

                @php
                    $user = Auth::user();
                @endphp
                <!-- Profile Dropdown (Hidden on Small Screens) -->
                <div class="hidden sm:flex items-center mx-2">
                    <button type="button"
                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full"
                            src="{{ Str::startsWith($user->profile_image, ['http://', 'https://']) ? $user->profile_image : asset('storage/' . $user->profile_image ?? '/images/default-avatar.jpg') }}"
                            alt="User Avatar">
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>