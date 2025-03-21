@props(['route', 'icon', 'label', 'count' => null])

<li>
    <a href="{{ route($route) }}"
        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
        <i data-lucide="{{ $icon }}"
            class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
        <span class="flex-1 ms-3 whitespace-nowrap">{{ $label }}</span>
        @if($count !== null)
        <span
        class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">{{ $count }}</span>
        @endif
    </a>
</li>
