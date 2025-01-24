<!-- resources/views/components/profile-img.blade.php -->
@props([
    'src' => '', // Default image source
    'alt' => 'Profile Image', // Default alt text
    'size' => 'md', // Default size (options: 'sm', 'md', 'lg', 'xl')
])

@php
    // Define sizes and their corresponding dimensions
    $sizes = [
        'sm' => 'w-8 h-8', // Small
        'md' => 'w-12 h-12', // Medium (default)
        'lg' => 'w-16 h-16', // Large
        'xl' => 'w-20 h-20', // Extra Large
    ];

    // Get the size class based on the prop
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div class="{{ $sizeClass }} rounded-full overflow-hidden ring-2 ring-blue-500 dark:ring-blue-400 ring-offset-2 ring-offset-white dark:ring-offset-gray-800">
    <img src="{{ filter_var($src, FILTER_VALIDATE_URL) ? $src : asset('storage/' . $src) }}"
         alt="{{ $alt }}"
         class="w-full h-full object-cover" />
</div>
