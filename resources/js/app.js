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

//resources/js/app.js
document.addEventListener("DOMContentLoaded", () => {
    initializeDeleteModal();
    NotificationModule.initialize();
});

// Notification Module
const NotificationModule = (() => {
    /**
     * Fetch and update the unread notifications count.
     */
    const updateUnreadCount = () => {
        fetch(window.routes.unreadCount, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
        })
            .then((response) => response.json())
            .then((data) => {
                const unreadCount = data.unreadCount;

                // Update Bell Counter (Dropdown Notification)
                const bellCounter = document.querySelector("#notification-bell .bg-red-600");
                if (bellCounter) {
                    if (unreadCount > 0) {
                        bellCounter.textContent = unreadCount;
                        bellCounter.classList.remove("hidden");
                    } else {
                        bellCounter.classList.add("hidden");
                    }
                }

                // Update Sidebar Counter
                const sidebarCounter = document.querySelector("#sidebar-notification-count");
                if (sidebarCounter) {
                    if (unreadCount > 0) {
                        sidebarCounter.textContent = unreadCount;
                        sidebarCounter.classList.remove("hidden");
                    } else {
                        sidebarCounter.classList.add("hidden");
                    }
                }
            })
            .catch((error) =>
                console.error("Error fetching unread notifications count:", error)
            );
    };


    /**
     * Mark a single notification as read.
     * @param {string} notificationId - The ID of the notification to mark as read.
     */
    const markSingleNotificationAsRead = (notificationId) => {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({}),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // Remove the unread indicator (red dot) for this notification
                    const notificationItem = document
                        .querySelector(
                            `.notification-link[data-notification-id="${notificationId}"]`
                        )
                        .closest(".notification-item");
                    const unreadIndicator = notificationItem.querySelector(
                        ".notification-unread-indicator"
                    );
                    if (unreadIndicator) {
                        unreadIndicator.remove();
                    }

                    // Update the unread count
                    updateUnreadCount();
                }
            })
            .catch((error) =>
                console.error("Error marking notification as read:", error)
            );
    };

    /**
     * Mark all notifications as read.
     */
    const markAllNotificationsAsRead = () => {
        fetch(window.routes.markAllAsRead, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({}),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    document
                        .querySelectorAll(".notification-unread-indicator")
                        .forEach((indicator) => indicator.remove());
                    updateUnreadCount();
                }
            })
            .catch((error) =>
                console.error("Error marking notifications as read:", error)
            );
    };

    /**
     * Initialize notification event listeners.
     */
    const initialize = () => {
        // Mark single notification as read when clicked
        const notificationLinks =
            document.querySelectorAll(".notification-link");
        notificationLinks.forEach((link) => {
            link.addEventListener("click", function (event) {
                const notificationId = link.dataset.notificationId;
                markSingleNotificationAsRead(notificationId);
            });
        });

        // Mark all notifications as read when the dropdown is opened
        const notificationBell = document.getElementById("notification-bell");
        const dropdownNotifications = document.getElementById(
            "dropdown-notifications"
        );
        if (notificationBell && dropdownNotifications) {
            notificationBell.addEventListener(
                "click",
                markAllNotificationsAsRead
            );
        }

        // Periodically update the unread notifications count (e.g., every 10 seconds)
        setInterval(updateUnreadCount, 10000);
    };

    return {
        initialize,
    };
})();

