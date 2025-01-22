<x-layout title="Categories">
    <div class="flex flex-col gap-4 px-2">
        <div class="flex justify-between items-center">
            <x-page-header>إدارة الأقسام</x-page-header>
            <a href="{{ route('admin.categories.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                إضافة قسم جديد
            </a>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            @forelse($categories as $category)
                <div class="relative group">
                    <!-- Gradient Glow Effect -->
                    <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300"></div>

                    <!-- Category Card -->
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col min-h-[400px]">
                        <!-- Card Header -->
                        <div class="p-5 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $category->name }}
                                </h3>
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.categories.show', $category) }}"
                                        class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="p-2 text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors duration-200"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

<!-- Subcategories Section -->
<div class="p-5 flex-1">
    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">الأقسام الفرعية</h4>
    <div class="space-y-2">
        @forelse($category->children->take(3) as $subcategory)
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $subcategory->name }}</span>
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <a href="{{ route('admin.categories.edit', $subcategory) }}"
                        class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </a>
                    <form action="{{ route('admin.categories.destroy', $subcategory) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-gray-400 hover:text-red-600 dark:hover:text-red-400"
                            onclick="return confirm('هل أنت متأكد من حذف هذا القسم الفرعي؟')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-2">
                لا توجد أقسام فرعية
            </p>
        @endforelse

        <!-- Show "View More" link if there are more than 3 subcategories -->
        @if($category->children->count() > 3)
            <div class="text-center mt-4">
                <a href="{{ route('admin.categories.show', $category) }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                    عرض المزيد
                </a>
            </div>
        @endif
    </div>
</div>

                        <!-- Card Footer -->
                        <div class="px-5 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 dark:text-gray-400">
                                    عدد الأقسام الفرعية: {{ $category->children->count() }}
                                </span>
                                @if($category->children->count() < 5)
                                    <a href="{{ route('admin.categories.create', ['parent_id' => $category->id]) }}"
                                        class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        إضافة قسم فرعي +
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">لا توجد أقسام</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">ابدأ بإضافة قسم جديد لموقعك</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.categories.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                إضافة قسم جديد
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>
</x-layout>
