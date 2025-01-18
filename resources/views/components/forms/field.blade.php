<!-- resources/views/components/forms/field.blade.php -->
@props(['label', 'name'])

<div class="form-group">
    @if ($label)
        <x-forms.label :$name :$label />
    @endif

    <div class="mt-1">
        {{ $slot }}
        <x-forms.error :error="$errors->first($name)" />
    </div>
</div>
