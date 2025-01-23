{{-- resources/views/components/badge.blade.php --}}

@props(['type' => 'default', 'label' => ''])

@php $colors = [
        'in-progress' => 'bg-indigo-200 text-indigo-800 dark:bg-indigo-700 dark:text-indigo-300',
        'completed' => 'bg-teal-200 text-teal-800 dark:bg-teal-700 dark:text-teal-300',
        'deleted_by_investor' => 'bg-orange-200 text-orange-800 dark:bg-orange-700 dark:text-orange-300',
        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
    ];

$classes = $colors[$type ?? 'default'] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'; @endphp

<span {{ $attributes->merge(['class' => "px-2 py-1 text-xs rounded-full $classes"]) }}>
    {{ __($label) }}
