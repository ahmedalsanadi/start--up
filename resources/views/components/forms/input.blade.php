<!-- resources/views/components/forms/input.blade.php -->
@props(['label', 'name'])

@php
    $defaults = [
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' => ' form-input ',
        'value' => old($name)
    ];
@endphp

<x-forms.field :$label :$name>
    <input {{ $attributes($defaults) }}>

</x-forms.field>
