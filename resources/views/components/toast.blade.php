<!-- Add this where you want the toasts to appear -->
<div id="toastContainer" class="toast-container" dir="rtl"></div>
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

<!-- Toast Container -->
<script>
    function showToast(message, type = 'success', duration = 5000) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;

        const icons = {
            success: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`,
            error: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`,
            warning: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            info: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`
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
