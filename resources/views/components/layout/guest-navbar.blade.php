<!-- Guest Navbar -->
<nav
    class="fixed w-full top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-800 transition-colors duration-300">

    <!-- Animated Border -->
    <div
        class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-blue-500 to-transparent opacity-40">
    </div>

    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo Section -->
            <div class="flex-shrink-0">
                <a href="{{ route('welcome') }}" class="flex items-center">
                    <img src="/logo.png" alt="StartBox" class="h-32 w-auto">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-10">
                <div class="relative group">
                    <a href="{{ route('welcome') }}" class="text-gray-700 dark:text-gray-200 font-medium py-2">
                        الرئيسية
                    </a>
                    <div
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300">
                    </div>
                </div>

                <div class="relative group">
                    <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-200 font-medium py-2">
                        الأفكار
                    </a>
                    <div
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300">
                    </div>
                </div>

                <div class="relative group">
                    <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-200 font-medium py-2">
                        الإعلانات
                    </a>
                    <div
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300">
                    </div>
                </div>

                <div class="relative group">
                    <a href="{{ route('about') }}" class="text-gray-700 dark:text-gray-200 font-medium py-2">
                        من نحن
                    </a>
                    <div
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300">
                    </div>
                </div>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center gap-4">

                <a href="{{ route('login') }}" class="relative group">
                    <div
                        class="absolute -inset-2 bg-gradient-to-r from-blue-600/20 to-blue-400/20 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                    </div>
                    <span class="relative text-gray-700 dark:text-gray-200 font-medium">تسجيل الدخول</span>
                </a>

                <a href="{{ route('register') }}" class="relative group">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-purple-800 to-blue-500 rounded-full transition-all duration-300 group-hover:opacity-90">
                    </div>
                    <span
                        class="relative px-6 py-2 inline-flex text-white font-medium group-hover:scale-105 transition-transform duration-300">
                        إنشاء حساب
                        <svg class="w-5 h-5 mr-2 mt-1 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </span>
                </a>
                <x-theme-toggle />
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button"
                class="md:hidden p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu"
        class="hidden md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 py-4 space-y-4">
            <a href="{{ route('welcome') }}"
                class="block text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                الرئيسية
            </a>
            <a href="{{ route('about') }}"
                class="block text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">
                من نحن
            </a>
            <div class="pt-4 border-t border-gray-200 dark:border-gray-800">
                <a href="{{ route('login') }}"
                    class="block text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 mb-4">
                    تسجيل الدخول
                </a>
                <a href="{{ route('register') }}"
                    class="block text-center px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700">
                    إنشاء حساب
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });


</script>
