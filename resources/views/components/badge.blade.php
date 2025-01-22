{{-- resources/views/components/badge.blade.php --}}

@props(['type' => 'default', 'label' => ''])

@php $colors = [
        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
    ];

$classes = $colors[$type ?? 'default'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'; @endphp

<span {{ $attributes->merge(['class' => "px-2 py-1 text-xs rounded-full $classes"]) }}>
    {{ __($label) }}