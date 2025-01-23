<x-layout title="الإعلانات">
    <!-- Header Section -->
    <div class="mb-8 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">إدارة الإعلانات</h2>
        <a href="{{ route('investor.announcements.create') }}"
            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200">
            إضافة إعلان جديد
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Card -->
        <div class="relative group">
            <!-- Gradient Glow Effect -->
            <div
                class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
            </div>

            <div
                class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">إجمالي الإعلانات</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['total'] }}</h3>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                </div>
            </div>
        </div>

        <!-- Pending Card -->
        <div class="relative group">
            <!-- Gradient Glow Effect -->
            <div
                class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
            </div>

            <div
                class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">قيد المراجعة</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['pending'] }}</h3>
                    </div>
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                </div>
            </div>
        </div>

        <!-- Approved Card -->
        <div class="relative group">
            <!-- Gradient Glow Effect -->
            <div
                class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
            </div>

            <div
                class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">الإعلانات الموافقة</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['approved'] }}</h3>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                </div>
            </div>
        </div>

        <!-- Rejected Card -->
        <div class="relative group">
            <!-- Gradient Glow Effect -->
            <div
                class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
            </div>

            <div
                class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">مرفوضة</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['rejected'] }}</h3>
                    </div>
                    <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div
                    class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
    <div class="p-4 border-b dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">قائمة الإعلانات</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">الوصف</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col">
                            <span>الموقع</span>
                            <div class="border-t border-gray-300 dark:border-gray-600 mt-1"></div>
                            <span>الميزانية</span>
                        </div>
                    </th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ البدء</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">حالة الموافقة</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">حالة الاعلان</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">الأفكار</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($announcements as $announcement)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                            {{ Str::limit($announcement->description, 50) }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex flex-col">
                                <div>
                                    <span>{{ $announcement->location }}</span>
                                </div>
                                <div class="border-t border-gray-300 dark:border-gray-600 my-1"></div>
                                <div>
                                    <span>{{ number_format($announcement->budget) }} ريال</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                            {{ $announcement->start_date->format('Y-m-d') }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <x-badge :type="$announcement->approval_status" :label="__('announcements.status.' . $announcement->approval_status)" />
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <x-badge :type="$announcement->status" :label="__('announcements.status.' . $announcement->status)" />
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                            {{ $announcement->ideas->count() }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex space-x-2 space-x-reverse items-center">
                                <!-- Eye Icon: View Details -->
                                <a href="{{ route('investor.announcements.show', $announcement) }}"
                                    class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>

                                <!-- Only show Edit and Delete buttons if the status is not 'completed' -->
                                @if ($announcement->status !== 'completed')
                                    <!-- Pencil Icon: Edit -->
                                    <a href="{{ route('investor.announcements.edit', $announcement) }}"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Trash Icon: Delete -->
                                    <x-delete-button :deleteUrl="route('investor.announcements.destroy', $announcement->id)"
                                        deleteConfirmMessage="هل أنت متأكد من حذف هذا الإعلان ؟" />
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            لا توجد إعلانات متاحة
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $announcements->links() }}
    </div>
</div>


</x-layout>
