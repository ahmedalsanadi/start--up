<x-layout title="إدارة الإعلانات">
    <div class="flex flex-col gap-4 px-2">
        <x-page-header>إدارة الإعلانات</x-page-header>

        <!-- Stats Grid -->
        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-3 lg:grid-cols-3" dir="rtl">
            <!-- Total Announcements -->
            <x-stat-card icon="megaphone" title="إجمالي الإعلانات" :value="$total_announcements" color="blue" />

            <!-- Pending Announcements -->
            <x-stat-card icon="clock" title="إعلانات قيد المراجعة" :value="$total_pending_announcements" color="yellow">
                <span>قيد الانتظار</span>
            </x-stat-card>

            <!-- Active Announcements -->
            <x-stat-card icon="check-circle" title="الإعلانات النشطة" :value="$total_active_announcements"
                color="green">
                <span>نشط</span>
            </x-stat-card>
        </div>

        <!-- Announcements Table -->
        <div
            class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Table Header -->
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 bg-gray-50 dark:bg-gray-800/50">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">قائمة الإعلانات</h3>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                المستثمر</th>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الوصف</th>
                            <th class="px-6 py-3 text-right text-sm font-medium uppercase tracking-wider">
                                <div class="flex flex-col gap-1">
                                    <div class="group">
                                        <div class="flex items-center gap-2">
                                            <i data-lucide="map-pin"
                                                class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                            <span class="py-1 text-pink-600 dark:text-pink-200">الموقع</span>
                                        </div>
                                    </div>
                                    <div class="group border-t border-gray-200 dark:border-gray-700 pt-1">
                                        <div class="flex items-center gap-2">
                                            <i data-lucide="dollar-sign"
                                                class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                            <span class="py-1 text-pink-600 dark:text-pink-200 ">الميزانية</span>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                تاريخ الانشاء</th>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الحالة</th>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($announcements as $announcement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $announcement->investor->name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white line-clamp-2">
                                        {{ $announcement->description }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <div class="group">
                                            <div class="flex items-center gap-2">
                                                <i data-lucide="map-pin"
                                                    class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                                <span
                                                    class="py-1 text-pink-600 dark:text-pink-200">{{ $announcement->location }}</span>
                                            </div>
                                        </div>
                                        <div class="group border-t border-gray-200 dark:border-gray-700 pt-1">
                                            <div class="flex items-center gap-2">
                                                <i data-lucide="dollar-sign"
                                                    class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                                <span class="py-1 text-pink-600 dark:text-pink-200 ">
                                                    {{ number_format($announcement->budget, 2) }} ريال
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $announcement->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                                    {{ $announcement->approval_status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                                                                    {{ $announcement->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                                                                    {{ $announcement->approval_status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                                        {{ __('announcements.status.' . $announcement->approval_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                    <div class="flex items-center gap-3">
                                        @if($announcement->approval_status === 'pending')
                                            <form action="{{ route('admin.announcements.update-status', $announcement) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="approval_status" value="approved">
                                                <button type="submit"
                                                    class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                                </button>
                                            </form>

                                            <!-- Reject Button -->
                                            <button type="button" onclick="openRejectModal('{{ $announcement->id }}')"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <i data-lucide="x-circle" class="w-5 h-5"></i>
                                            </button>
                                        @endif

                                        <!-- View Details -->
                                        <button type="button" onclick="viewDetails('{{ $announcement->id }}')"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i data-lucide="eye" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    لا توجد إعلانات متاحة
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>

    <!-- Reject Announcement Modal -->
    <x-modals.reject-announ-modal />
</x-layout>