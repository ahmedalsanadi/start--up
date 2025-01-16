@props(['title'])

<div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 border-b border-gray-200 dark:border-gray-700 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
            {{ $title }}
        </h3>
    </div>
    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
        {{ $slot }}
    </ul>
</div>
