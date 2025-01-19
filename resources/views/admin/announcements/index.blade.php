<x-layout title="إدارة الإعلانات">
    <div class="flex flex-col gap-4 px-2">
        <x-page-header>إدارة الإعلانات</x-page-header>

        <!-- Stats Grid -->
        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-3 lg:grid-cols-3" dir="rtl">
            <!-- Total Announcements -->
            <x-stat-card
                icon="megaphone"
                title="إجمالي الإعلانات"
                :value="$announcements->total()"
                color="blue"
            />

            <!-- Pending Announcements -->
            <x-stat-card
                icon="clock"
                title="إعلانات قيد المراجعة"
                :value="$announcements->where('approval_status', 'pending')->count()"
                color="yellow">
                <span>قيد الانتظار</span>
            </x-stat-card>

            <!-- Active Announcements -->
            <x-stat-card
                icon="check-circle"
                title="الإعلانات النشطة"
                :value="$announcements->where('status', 'active')->count()"
                color="green">
                <span>نشط</span>
            </x-stat-card>
        </div>

        <!-- Announcements Table -->
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Table Header -->
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 bg-gray-50 dark:bg-gray-800/50">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">قائمة الإعلانات</h3>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">المستثمر</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">الوصف</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">الموقع</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">الميزانية</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">الحالة</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">الإجراءات</th>
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
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $announcement->location }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ number_format($announcement->budget, 2) }} ريال</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $announcement->approval_status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                                        {{ $announcement->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                                        {{ $announcement->approval_status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                                        {{ __('announcements.status.' . $announcement->approval_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                    <div class="flex items-center gap-3">
                                        @if($announcement->approval_status === 'pending')
                                            <form action="{{ route('admin.announcements.update-status', $announcement) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="approval_status" value="approved">
                                                <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                                                </button>
                                            </form>

                                            <!-- Reject Button -->
                                            <button type="button"
                                                onclick="openRejectModal('{{ $announcement->id }}')"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                <i data-lucide="x-circle" class="w-5 h-5"></i>
                                            </button>
                                        @endif

                                        <!-- View Details -->
                                        <button type="button"
                                            onclick="viewDetails('{{ $announcement->id }}')"
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

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-right sm:w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            سبب الرفض
                        </h3>
                        <div class="mt-2">
                            <form id="rejectForm" action="" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="approval_status" value="rejected">
                                <textarea name="rejection_reason"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    rows="4"
                                    required></textarea>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="submit" form="rejectForm"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        تأكيد الرفض
                    </button>
                    <button type="button" onclick="closeRejectModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openRejectModal(announcementId) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = `/admin/announcements/${announcementId}/update-status`;
            modal.classList.remove('hidden');
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
        }

        function viewDetails(announcementId) {
            // Implement view details functionality
            window.location.href = `/admin/announcements/${announcementId}`;
        }
    </script>
    @endpush
</x-layout>
