@props(['action', 'method', 'status', 'color'])

<form action="{{ $action }}" method="POST">
    @csrf
    @method($method ?? 'POST')
    <input type="hidden" name="status" value="{{ $status }}">
    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-{{ $color }}-600 hover:bg-{{ $color }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $color }}-500">
        {{ $slot }}
    </button>
</form>
