<!-- resources/views/components/forms/select.blade.php -->
@props(['label', 'name'])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' => ' form-input '
    ];
@endphp

<x-forms.field :$label :$name>
    <select {{ $attributes($defaults) }}>
        {{ $slot }}
    </select>
</x-forms.field>

