// resources/js/app.js
import "./bootstrap";
import "flowbite"; // Keep Flowbite
import "./theme-toggle";
import Alpine from "alpinejs";
import { initializeDeleteModal } from "./delete-modal";
window.Alpine = Alpine;
Alpine.start();

//delete model
document.addEventListener("DOMContentLoaded", () => {
    initializeDeleteModal();
});
