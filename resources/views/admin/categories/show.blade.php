<x-layout title="تفاصيل القسم">
    <div class="flex flex-col gap-4 px-2">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <x-page-header>تفاصيل القسم</x-page-header>
            <a href="{{ route('categories.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                العودة إلى الأقسام
            </a>
        </div>

        <!-- Parent Category Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">معلومات القسم الرئيسي</h2>

            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">اسم القسم:</label>
                    <p class="text-lg text-gray-900 dark:text-white">{{ $category->name }}</p>
                </div>

                <!-- Parent Category (if exists) -->
                @if($parentCategory)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">الفئة الأب:</label>
                        <p class="text-lg text-gray-900 dark:text-white">
                            <a href="{{ route('categories.show', $parentCategory) }}"
                                class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                                {{ $parentCategory->name }}
                            </a>
                        </p>
                    </div>
                @else
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">الفئة الأب:</label>
                        <p class="text-lg text-gray-900 dark:text-white">لا يوجد</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Children Categories Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">الفئات الفرعية</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الاسم
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($children as $child)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $child->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <!-- Edit Button -->
                                        <a href="{{ route('categories.edit', $child) }}"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('categories.destroy', $child) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا القسم الفرعي؟')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    لا توجد فئات فرعية
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="mt-6">
                {{ $children->links() }}
            </div>
        </div>
    </div>
</x-layout>
