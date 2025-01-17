<aside id="logo-sidebar"
    class="fixed top-0 right-0 z-40 w-64 h-screen pt-24  transition-transform duration-300 ease-in-out translate-x-full bg-gray-100 border-l border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto ">
        <ul class="space-y-2 font-medium">
            <!-- Dashboard -->
            <li>
                <a href={{ route('admin.index') }}
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <!-- Lucide Icon: Layout Dashboard -->
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                    <span class="ms-3">لوحة التحكم</span>
                </a>
            </li>

            <!-- Manage Ideas -->
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <!-- Lucide Icon: Lightbulb -->
                    <i data-lucide="lightbulb" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">إدارة الافكار</span>
                    <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">0</span>
                </a>
            </li>

            <!-- Manage Users (Admin Only) -->
            @can('is_admin')
                <li>
                    <a href="{{ route('users.index') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <!-- Lucide Icon: Users -->
                        <i data-lucide="users" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap">ادارة المستخدمين</span>
                    </a>
                </li>
            @endcan

            <!-- Manage Investors -->
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <!-- Lucide Icon: Briefcase -->
                    <i data-lucide="briefcase" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">ادارة المستثمرين</span>
                </a>
            </li>

            <!-- Notifications -->
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <!-- Lucide Icon: Bell -->
                    <i data-lucide="bell" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">الاشعارات</span>
                    <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ Auth::user()->unreadNotifications->count() }}</span>
                </a>
            </li>
        </ul>

        <!-- Bottom Section -->
        <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700">
            <!-- Profile -->
            <li>
                <a href="#"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <!-- Lucide Icon: User -->
                    <i data-lucide="user" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                    <span class="flex-1 ms-3 whitespace-nowrap">الملف الشخصي</span>
                </a>
            </li>

            <!-- Logout -->
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-right">
                        <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <!-- Lucide Icon: Log Out -->
                            <i data-lucide="log-out" class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                            <span class="flex-1 ms-3 whitespace-nowrap">تسجيل الخروج</span>
                        </div>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>


