<!-- resources/views/components/forms/form.blade.php -->
@props(['method' => 'GET'])

<form {{ $attributes->merge(['class' => ' ', 'method' => $method === 'GET' ? 'GET' : 'POST']) }}>
    @if ($method !== 'GET')
        @csrf
        @method($method) <!-- This will be either POST, PUT, PATCH, or DELETE -->
    @endif
    {{ $slot }}
</form>
