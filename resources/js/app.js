// Import required libraries and modules
import "./bootstrap";
import "flowbite"; // Keep Flowbite
import "./theme-toggle";
import Alpine from "alpinejs";
import { initializeDeleteModal } from "./delete-modal";

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Initialize delete modal
document.addEventListener("DOMContentLoaded", () => {
    initializeDeleteModal();
});

// Notification Module
const NotificationModule = (() => {
    /**
     * Fetch and update the unread notifications count.
     */
    const updateUnreadCount = () => {
        fetch('{{ route("notifications.unread-count") }}', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
        .then(response => response.json())
        .then(data => {
            const unreadCountElement = document.querySelector('#notification-bell .bg-red-600');
            if (unreadCountElement) {
                if (data.unreadCount > 0) {
                    unreadCountElement.textContent = data.unreadCount;
                    unreadCountElement.classList.remove('hidden');
                } else {
                    unreadCountElement.classList.add('hidden');
                }
            }
        })
        .catch(error => console.error('Error fetching unread notifications count:', error));
    };

    /**
     * Mark a single notification as read.
     * @param {string} notificationId - The ID of the notification to mark as read.
     */
    const markSingleNotificationAsRead = (notificationId) => {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the unread indicator (red dot) for this notification
                const notificationItem = document.querySelector(`.notification-link[data-notification-id="${notificationId}"]`).closest('.notification-item');
                const unreadIndicator = notificationItem.querySelector('.notification-unread-indicator');
                if (unreadIndicator) {
                    unreadIndicator.remove();
                }

                // Update the unread count
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
    };

    /**
     * Mark all notifications as read.
     */
    const markAllNotificationsAsRead = () => {
        fetch('{{ route("notifications.mark-as-read") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove all unread indicators (red dots)
                const unreadIndicators = document.querySelectorAll('.notification-unread-indicator');
                unreadIndicators.forEach(indicator => indicator.remove());

                // Update the unread count
                updateUnreadCount();
            }
        })
        .catch(error => console.error('Error marking notifications as read:', error));
    };

    /**
     * Initialize notification event listeners.
     */
    const initialize = () => {
        // Mark single notification as read when clicked
        const notificationLinks = document.querySelectorAll('.notification-link');
        notificationLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                const notificationId = link.dataset.notificationId;
                markSingleNotificationAsRead(notificationId);
            });
        });

        // Mark all notifications as read when the dropdown is opened
        const notificationBell = document.getElementById('notification-bell');
        const dropdownNotifications = document.getElementById('dropdown-notifications');
        if (notificationBell && dropdownNotifications) {
            notificationBell.addEventListener('click', markAllNotificationsAsRead);
        }

        // Periodically update the unread notifications count (e.g., every 30 seconds)
        setInterval(updateUnreadCount, 30000); // 30 seconds
    };

    return {
        initialize,
    };
})();

// Initialize Notification Module
document.addEventListener("DOMContentLoaded", () => {
    NotificationModule.initialize();
});
