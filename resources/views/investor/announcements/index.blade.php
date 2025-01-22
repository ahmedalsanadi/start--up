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
                    <p class="text-sm text-gray-500 dark:text-gray-400">الإعلانات النشطة</p>
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
                        <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">الموقع</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">الميزانية</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ البدء</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">الحالة</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">الأفكار</th>
                        <th class="px-4 py-3 text-sm font-medium text-gray-500 dark:text-gray-400">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($announcements as $announcement)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ Str::limit($announcement->description, 50) }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $announcement->location }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ number_format($announcement->budget) }} ريال
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                {{ $announcement->start_date->format('Y-m-d') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <x-badge :type="$announcement->approval_status" :label="__('announcements.status.' . $announcement->approval_status)" />
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

                                    <!-- Pencil Icon: Edit -->
                                    <a href="{{ route('investor.announcements.edit', $announcement) }}"
                                        class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Trash Icon: Delete -->
                                    <button onclick="openDeleteModal({{ $announcement->id }})"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
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


    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center">
        <div class="relative mx-auto w-full max-w-md p-1">
            <div
                class="relative bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-blue-50 dark:bg-blue-900/20 rounded-full -translate-y-32 translate-x-32 blur-3xl">
                </div>

                <div class="relative p-6 text-center" dir="rtl">
                    <div
                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white mb-2">
                        هل أنت متأكد أنك تريد حذف هذا الإعلان؟
                    </h3>

                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        لن تتمكن من استعادة هذا الإعلان بعد الحذف.
                    </p>

                    <div class="flex justify-center gap-3">
                        <form id="deleteForm" method="POST" class="flex gap-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg transition-all duration-200 shadow-lg hover:shadow-red-500/25">
                                حذف
                            </button>
                            <button type="button" onclick="closeDeleteModal()"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 hover:from-gray-300 hover:to-gray-400 dark:hover:from-gray-600 dark:hover:to-gray-700 rounded-lg transition-all duration-200">
                                إلغاء
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openDeleteModal(announcementId) {
                document.getElementById('deleteModal').classList.remove('hidden');
                // Fix the route URL to match your defined routes
                document.getElementById('deleteForm').action = `{{ url('/investor/announcement') }}/${announcementId}`;
            }

            function closeDeleteModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }
        </script>
    @endpush



</x-layout>
