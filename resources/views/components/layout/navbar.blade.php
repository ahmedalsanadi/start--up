@php
    $user = Auth::user();
    $notifications = auth()->user()->notifications()->latest()->take(5)->get();
    $unreadCount = auth()->user()->unreadNotifications()->count();
@endphp

<nav class="fixed top-0 z-50 w-full border-b bg-gray-100 border-gray-200 dark:bg-gray-800 dark:border-gray-700 transition-colors duration-300 ease-in-out"
    dir="rtl">
    <div class="px-3 py-2 lg:px-5 lg:pr-3">
        <div class="flex items-center justify-between">
            <!-- Mobile Sidebar Button -->
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                type="button"
                class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">فتح القائمة الجانبية</span>
                <!-- Lucide Icon: Menu -->
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>

            <!-- Logo Section -->
            <div class="flex items-center justify-start rtl:justify-end">
                <a href="#" class="flex items-center gap-2">
                    <!-- Animated Logo Container -->
                    <div class="relative group">
                        <div class="w-12 h-12 relative">
                            <!-- Gradient Background -->
                            <div
                                class="absolute inset-1 rounded-xl bg-gradient-to-br from-violet-600 via-indigo-500 to-cyan-400 animate-pulse">
                                <div
                                    class="absolute inset-0 rounded-xl bg-gradient-to-tr from-pink-500 via-purple-500 to-indigo-500 mix-blend-overlay">
                                </div>
                            </div>
                            <!-- Star Icon -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-6 h-6 text-white transform rotate-12">
                                    <!-- Lucide Icon: Star -->
                                    <i data-lucide="star" class="w-full h-full"></i>
                                </div>
                            </div>
                            <!-- Glowing Effect -->
                            <div
                                class="absolute -inset-1 rounded-xl bg-gradient-to-br from-violet-600/30 via-indigo-500/30 to-cyan-400/30 blur-lg group-hover:opacity-75 transition duration-300">
                            </div>
                        </div>
                    </div>
                    <!-- Text Logo (Hidden on Small Screens) -->
                    <span class="hidden md:block text-2xl font-extrabold">
                        <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-violet-600 via-indigo-500 to-cyan-400">Start</span>
                        <span
                            class="bg-clip-text text-transparent bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500">-up</span>
                    </span>
                </a>
            </div>

            <!-- Right-Aligned Menu (Theme, Notifications, Profile) -->
            <div class="flex items-center gap-4">
                <!-- Theme Toggle (Hidden on Small Screens) -->
                <button id="theme-toggle" type="button"
                    class="hidden sm:flex text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                    <!-- Lucide Icon: Moon (Dark Mode) -->
                    <i id="theme-toggle-dark-icon" data-lucide="moon" class="hidden w-5 h-5"></i>
                    <!-- Lucide Icon: Sun (Light Mode) -->
                    <i id="theme-toggle-light-icon" data-lucide="sun" class="hidden w-5 h-5"></i>
                </button>

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
                    <!-- Profile Dropdown Content -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white">{{ $user->name }}</p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300">{{ $user->email }}
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Home</a>
                            </li>
                            <li>
                                <a href="/manage-account"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Settings</a>
                            </li>
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
