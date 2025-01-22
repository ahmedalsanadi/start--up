@props(['stage'])

@php
    // Define classes based on the stage
    $classes = [
        'new' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'initial_acceptance' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'under_review' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'expert_consultation' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
        'final_decision' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    ];

    // Default classes if the stage is not found
    $defaultClasses = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';

    // Apply the appropriate classes based on the stage
    $stageClasses = $classes[$stage] ?? $defaultClasses;
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $stageClasses }}">
    {{ __("stages.{$stage}") }}
</span>
