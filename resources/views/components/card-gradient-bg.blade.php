<!-- views/components/card-gradient-bg.blade.php -->

<div class="relative">
    <!-- Gradient Glow Effect -->
    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20"></div>

    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 relative overflow-hidden"
        dir="rtl">

        <!-- Decorative Background Element -->
        <div
            class="absolute top-0 right-0 w-64 h-64 bg-blue-50 dark:bg-blue-900/20 rounded-full -translate-y-32 translate-x-32 blur-3xl">
        </div>

        {{ $slot }}

    </div>
</div>
