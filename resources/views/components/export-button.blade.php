@props(['type', 'filters' => []])

<form action="{{ route('export', ['type' => $type]) }}" method="POST" class="inline">
    @csrf
    @foreach($filters as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach

    <button type="submit" {{ $attributes->merge(['class' => 'px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 flex items-center gap-2']) }}>
        <i data-lucide="download" class="w-4 h-4"></i>
        {{ $slot ?? 'تصدير النتائج' }}
    </button>
</form>
