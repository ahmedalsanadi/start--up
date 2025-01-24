<x-layout title="إدارة الإعلانات">
    <div class="flex flex-col gap-4 px-2">

        <!-- Page Header with Breadcrumb -->
        <div class="flex justify-between items-center mb-6">
            <x-page-header>إدارة الإعلانات</x-page-header>
            <nav class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <span>لوحة التحكم</span>
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                <span class=" text-blue-600 dark:text-blue-400 ">إدارة الإعلانات</span>
            </nav>
        </div>


        <!-- Stats Cards -->
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-stat-card icon="megaphone" title="إجمالي الإعلانات" :value="$total_announcements" color="blue" />
            <x-stat-card icon="clock" title="إعلانات قيد المراجعة" :value="$total_pending_announcements"
                color="yellow" />
            <x-stat-card icon="check-circle" title="الإعلانات النشطة" :value="$total_active_announcements"
                color="green" />
            <x-stat-card icon="x-circle" title="الإعلانات المرفوضة" :value="$total_rejected_announcements"
                color="blue" />
        </div>

        <!-- Filters Section -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mt-6">
            <!-- Filter Form -->
            <form id="filterForm" action="{{ route('admin.announcements.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div class="relative">
                        <span class="absolute right-3 top-2.5 text-gray-400">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pr-10 pl-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                            placeholder="البحث عن إعلان...">
                    </div>

                    <!-- Date Range Inputs -->
                    <div class="relative">
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="w-full pr-10 pl-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                            placeholder="من تاريخ">
                        <label
                            class="absolute -top-2 right-2 text-xs text-gray-600 bg-white dark:text-gray-400 dark:bg-gray-800 px-2 py-0.5 rounded-full">من
                            تاريخ</label>
                    </div>

                    <div class="relative">
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full pr-10 pl-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                            placeholder="إلى تاريخ">
                        <label
                            class="absolute -top-2 right-2 text-xs text-gray-600 bg-white dark:text-gray-400 dark:bg-gray-800 px-2 py-0.5 rounded-full">إلى
                            تاريخ</label>
                    </div>

                    <!-- Admin Approval Status Dropdown -->
                    <select name="status"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                        <option value="">جميع الحالات</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            معلق (قيد المراجعة)
                        </option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>مقبول</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                    </select>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <!-- Filter and Reset Buttons -->
                    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 flex items-center justify-center gap-2">
                            <i data-lucide="filter" class="w-4 h-4"></i>
                            <span>تطبيق الفلتر</span>
                        </button>
                        <a href="{{ route('admin.announcements.index') }}"
                            class="w-full sm:w-auto px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-200 flex items-center justify-center gap-2">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                            <span>إعادة تعيين</span>
                        </a>
                    </div>

                    <!-- Export Button -->
                    <button type="button" id="exportBtn"
                        class="w-full sm:w-auto px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 flex items-center justify-center gap-2">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        <span>تصدير النتائج</span>
                    </button>
                </div>
            </form>

            <!-- Export Form (Hidden) -->
            <form id="exportForm" action="{{ route('export', ['type' => 'announcement']) }}" method="POST"
                class="hidden">
                @csrf
                <!-- Hidden Inputs for Filters -->
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                <input type="hidden" name="date_to" value="{{ request('date_to') }}">
            </form>
        </div>


        <!-- Announcements Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Table Header -->
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">قائمة الإعلانات</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        عدد النتائج: {{ $announcements->total() }}
                    </span>
                </div>
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
                                    <div class="flex items-center gap-3">
                                        <!-- Investor Profile Image -->
                                        <x-profile-img :src="$announcement->investor->profile_image ?? 'images/default-profile.png'" :alt="$announcement->investor->name" size="sm" />
                                        <!-- Investor Name -->
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
                                    <x-badge :type="$announcement->approval_status" :label="__('announcements.status.' . $announcement->approval_status)" />
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
                                        <a href="{{ route('admin.announcements.show', $announcement) }}"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            <i data-lucide="eye" class="w-5 h-5"></i>
                                        </a>
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

            <!-- Enhanced Pagination -->
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
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
                                    rows="4" required></textarea>
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
                form.action = `/admin/announcements/${announcementId}`;
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
        <script>
            function handleDateInputs() {
                const dateInputs = document.querySelectorAll('input[type="date"]');
                dateInputs.forEach(input => {
                    if (!input.value) {
                        input.type = 'text';
                    }

                    input.addEventListener('focus', function () {
                        this.type = 'date';
                    });

                    input.addEventListener('blur', function () {
                        if (!this.value) {
                            this.type = 'text';
                        }
                    });
                });
            }

            function handleRealTimeSearch() {
                let searchTimeout;
                const searchInput = document.querySelector('input[name="search"]');
                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            document.getElementById('filterForm').submit();
                        }, 500);
                    });
                }
            }

            function handleExport() {
                const exportBtn = document.getElementById('exportBtn');
                if (exportBtn) {
                    exportBtn.addEventListener('click', function () {
                        const filterForm = document.getElementById('filterForm');
                        const search = filterForm.querySelector('input[name="search"]').value;
                        const status = filterForm.querySelector('select[name="status"]').value;
                        const dateFrom = filterForm.querySelector('input[name="date_from"]').value;
                        const dateTo = filterForm.querySelector('input[name="date_to"]').value;

                        const exportForm = document.getElementById('exportForm');
                        exportForm.querySelector('input[name="search"]').value = search;
                        exportForm.querySelector('input[name="status"]').value = status;
                        exportForm.querySelector('input[name="date_from"]').value = dateFrom;
                        exportForm.querySelector('input[name="date_to"]').value = dateTo;

                        exportForm.submit();
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                handleDateInputs();
                handleRealTimeSearch();
                handleExport();
            });
        </script>
    @endpush
</x-layout>