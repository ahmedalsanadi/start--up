<!-- resources/views/components/key-details-grid.blade.php -->
@props(['idea'])

@php
    $cardsInfo = [
        ['icon' => 'map-pin', 'label' => 'الموقع', 'value' => $idea->location, 'iconColor' => 'text-blue-500 dark:text-blue-300'],
        ['icon' => 'dollar-sign', 'label' => 'الميزانية', 'value' => number_format($idea->budget, 2) . ' ريال', 'iconColor' => 'text-green-500 dark:text-green-300'],
        ['icon' => 'lightbulb', 'label' => 'نوع الفكرة', 'value' => $idea->idea_type === 'creative' ? 'إبداعية' : 'تقليدية', 'iconColor' => 'text-purple-500 dark:text-purple-300'],
        ['icon' => 'calendar', 'label' => 'تاريخ الانتهاء', 'value' => $idea->expiry_date ? $idea->expiry_date->format('Y/m/d') : 'غير محدد', 'iconColor' => 'text-yellow-500 dark:text-yellow-300'],
        ['icon' => 'alert-circle', 'label' => 'حالة الموافقة', 'value' => __("ideas.status.{$idea->approval_status}"), 'iconColor' => 'text-red-500 dark:text-red-300'],
        [
            'icon' => 'trending-up',
            'label' => 'المرحلة',
            'value' => $idea->idea_type === 'traditional' ? 'لا يوجد مرحلة' : __("ideas.stages.{$idea->stage}"),
            'iconColor' => 'text-gray-500 dark:text-gray-400'
        ],
    ]
@endphp

@if ($idea->idea_type === 'traditional')
    <div class="lg:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach ($cardsInfo as $card)
            <x-small-detailed-card :icon="$card['icon']" :label="$card['label']" :value="$card['value']"
                :iconColor="$card['iconColor']" />
        @endforeach

    </div>

@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($cardsInfo as $card)
            <x-small-detailed-card :icon="$card['icon']" :label="$card['label']" :value="$card['value']"
                :iconColor="$card['iconColor']" />
        @endforeach
    </div>

@endif
