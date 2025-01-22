<!-- resources/views/components/small-detailed-card.blade.php -->
@props([
    'icon' => 'alert-circle', // Default icon
    'label' => 'Label', // Default label
    'value' => 'Value', // Default value
    'iconColor' => 'text-blue-500 dark:text-blue-300', // Default icon color
])

<div class="my-2">
    <div class="flex items-center gap-3">
        <!-- Icon Container -->
        <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
            <i data-lucide="{{ $icon }}" class="w-5 h-5 {{ $iconColor }}"></i>
        </div>

        <!-- Label and Value -->
        <div class="flex flex-col justify-center">
            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $label }}</span>
            <p class="text-gray-600 dark:text-gray-400">{{ $value }}</p>
        </div>
    </div>
</div>
