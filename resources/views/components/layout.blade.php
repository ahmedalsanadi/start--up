<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Home' }}</title>
    <!-- Vite for CSS & JavaScript -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Add this in the <head> section -->
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

</head>

<body class="bg-white dark:bg-gray-900">

    <x-toast />

    @if ($title != 'Login' && $title != 'Register' && $title != 'Commercial Registration' && $title != 'Registration Pending')


        <!-- Navbar -->
        @auth
            <x-layout.navbar />
        @endauth


        <!-- Sidebar -->
        <x-layout.sidebar />

        <div class="p-4 sm:mr-64">
            <div class="p-4 border-2 border-gray-300 border-dashed rounded-lg dark:border-gray-700 overflow-y-hidden mt-20">
                {{ $slot }}
            </div>
        </div>


    @else
        {{ $slot }}
    @endif



    @stack('scripts')

    <!-- Include Lucide Icons Script -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const drawer = document.getElementById('logo-sidebar');
            const drawerToggle = document.querySelector('[data-drawer-toggle="logo-sidebar"]');

            // Create backdrop element
            const backdrop = document.createElement('div');
            backdrop.className = 'fixed inset-0 bg-gray-900 bg-opacity-50 z-30 hidden transition-opacity duration-300 ease-in-out opacity-0';
            document.body.appendChild(backdrop);

            function openDrawer() {
                drawer.classList.remove('translate-x-full');
                drawer.classList.add('translate-x-0');
                backdrop.classList.remove('hidden');
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                }, 10);
                document.body.style.overflow = 'hidden';
            }

            function closeDrawer() {
                drawer.classList.remove('translate-x-0');
                drawer.classList.add('translate-x-full');
                backdrop.classList.add('opacity-0');
                setTimeout(() => {
                    backdrop.classList.add('hidden');
                }, 300);
                document.body.style.overflow = '';
            }

            drawerToggle.addEventListener('click', function (e) {
                e.stopPropagation();
                const isVisible = !drawer.classList.contains('translate-x-full');

                if (isVisible) {
                    closeDrawer();
                } else {
                    openDrawer();
                }
            });

            // Close drawer when clicking on backdrop
            backdrop.addEventListener('click', function () {
                closeDrawer();
            });

            // Handle escape key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && !drawer.classList.contains('translate-x-full')) {
                    closeDrawer();
                }
            });

            // Prevent drawer from closing when clicking inside it
            drawer.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });
    </script>
</body>

</html>
