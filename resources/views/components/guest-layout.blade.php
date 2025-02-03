<!-- resources/views/components/layout.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Home' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    <!-- Inline script to set dark mode before rendering -->
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

<style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 1s ease-out forwards;
        }

        .geometric-bg {
            background-image: radial-gradient(circle at 1px 1px, #3b82f6 1px, transparent 0);
            background-size: 40px 40px;
        }

        .wave-shape {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave-shape svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 150px;
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900">
    <x-toast />
    <!-- Navbar -->

    @guest
    <x-layout.guest-navbar />
    @endguest



    <!-- Content Area -->
    @if (!in_array($title, ['Login', 'Register']))
        <div class="pt-4 pb-10 px-4">
            <div class="p-4 overflow-y-hidden mt-10">
                {{ $slot }}
            </div>
        </div>
    @else
        <div class="overflow-y-hidden">
            {{ $slot }}
        </div>
    @endif


    <!-- Delete Modal -->
    <x-delete-modal />

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
            // drawer.addEventListener('click', function (e) {
            //     e.stopPropagation();
            // });
        });



    </script>
</body>

</html>
