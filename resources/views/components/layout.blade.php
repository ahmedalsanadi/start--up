<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Home' }}</title>
    <!-- Vite for CSS & JavaScript -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white dark:bg-gray-900">

    <!-- Add this where you want the toasts to appear -->
    <div id="toastContainer" class="toast-container" dir="ltr"></div>
    @if(Session::has('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast('{{ Session::get('success') }}', 'success');
            });
        </script>
    @endif

    @if(Session::has('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                showToast('{{ Session::get('error') }}', 'error');
            });
        </script>
    @endif

    @if ($title != 'Login' && $title != 'Register' && $title != 'Commercial Registration' && $title != 'Registration Pending')


        <!-- Navbar -->
        <x-layout.navbar />

        <!-- Sidebar -->
        <x-layout.sidebar />

        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
                {{ $slot }}
            </div>
        </div>


    @else
        {{ $slot }}
    @endif




    <!-- Toast Container -->
    <script>
        function showToast(message, type = 'success', duration = 5000) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            const icons = {
                success: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`,
                error: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`
            };

            toast.innerHTML = `
        <div class="toast-content">
            <div class="toast-icon">
                ${icons[type]}
            </div>
            <div class="toast-message">${message}</div>
            <div class="toast-close" onclick="closeToast(this.parentElement.parentElement)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>
        <div class="toast-progress">
            <div class="toast-progress-bar" style="width: 100%"></div>
        </div>
    `;

            container.appendChild(toast);

            // Start progress bar animation
            const progressBar = toast.querySelector('.toast-progress-bar');
            progressBar.style.transition = `width ${duration}ms linear`;

            // Use setTimeout to ensure the transition is applied
            setTimeout(() => {
                progressBar.style.width = '0%';
            }, 10);

            // Remove toast after duration
            const timeout = setTimeout(() => {
                closeToast(toast);
            }, duration);

            // Store timeout in toast element
            toast.dataset.timeout = timeout;
        }

        function closeToast(toast) {
            // Clear the timeout
            clearTimeout(parseInt(toast.dataset.timeout));

            // Add sliding out animation
            toast.style.animation = 'slideOut 0.5s ease forwards';

            // Remove toast after animation
            setTimeout(() => {
                toast.remove();
            }, 500);
        }

    </script>
</body>

</html>
