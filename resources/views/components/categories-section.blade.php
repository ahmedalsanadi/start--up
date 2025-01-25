<!-- resources/views/components/categories-section.blade.php -->
@props(['categories'])

<div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">التصنيفات</h2>
    <div class="flex flex-wrap gap-2">
        @foreach($categories as $category)
            <span class="px-3 py-1 bg-purple-900 text-purple-200 rounded-full text-sm hover:bg-purple-800 transition-colors duration-200">
                {{ $category->name }}
            </span>
        @endforeach
    </div>
</div>
