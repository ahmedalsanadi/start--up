<!-- resources/views/components/profile-img.blade.php -->
@props([
    'src' => '', // Default image source
    'alt' => 'Profile Image', // Default alt text
])

<div class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-blue-500 dark:ring-blue-400 ring-offset-2 ring-offset-white dark:ring-offset-gray-800">
    <img src="{{ filter_var($src, FILTER_VALIDATE_URL) ? $src : asset('storage/' . $src) }}"
         alt="{{ $alt }}"
         class="w-full h-full object-cover" />
</div>
