<!-- resources/views/components/profile-img.blade.php -->
@props([
    'src' => '', 
    'alt' => 'Profile Image',
    'size' => 'md',
])

@php
    // Define sizes and their corresponding dimensions
    $sizes = [
        'xs' => 'w-4 h-4',
        'sm' => 'w-8 h-8', // Small
        'md' => 'w-12 h-12', // Medium (default)
        'lg' => 'w-16 h-16', // Large
        'xl' => 'w-20 h-20', // Extra Large
    ];

    // Get the size class based on the prop
    $sizeClass = $sizes[$size] ?? $sizes['md'];

    // Determine the image source
    if (empty($src)) {
        // If no image is provided, use the default avatar
        $imageSrc = '/default-avatar.jpg';
    } else {
        // Check if the image is a URL
        if (filter_var($src, FILTER_VALIDATE_URL)) {
            // If it's a URL, use it directly
            $imageSrc = $src;
        } else {
            // If it's not a URL, assume it's stored locally and prepend the storage path
            $imageSrc = asset('storage/' . $src);
        }
    }
@endphp

<div class="{{ $sizeClass }} rounded-full overflow-hidden ring-2 ring-blue-500 dark:ring-blue-400 ring-offset-2 ring-offset-white dark:ring-offset-gray-800">
    <img src="{{ $imageSrc }}"
         alt="{{ $alt }}"
         class="w-full h-full object-cover" />
</div>
