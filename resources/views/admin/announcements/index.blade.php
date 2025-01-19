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
        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-3 lg:grid-cols-3" dir="rtl">
            <x-stat-card icon="megaphone" title="إجمالي الإعلانات" :value="$total_announcements" color="blue" />
            <x-stat-card icon="clock" title="إعلانات قيد المراجعة" :value="$total_pending_announcements" color="yellow">
                <span>قيد الانتظار</span>
            </x-stat-card>
            <x-stat-card icon="check-circle" title="الإعلانات النشطة" :value="$total_active_announcements"
                color="green">
                <span>نشط</span>
            </x-stat-card>
        </div>

        <!-- Filters Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mt-6">
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
                        <label class="absolute -top-2 right-2 text-xs text-gray-600 bg-white dark:text-gray-400 dark:bg-gray-800 px-2 py-0.5 rounded-full">من تاريخ</label>
                    </div>

                    <div class="relative">
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full pr-10 pl-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                            placeholder="إلى تاريخ">
                        <label class="absolute -top-2 right-2 text-xs text-gray-600 bg-white dark:text-gray-400 dark:bg-gray-800 px-2 py-0.5 rounded-full">إلى تاريخ</label>
                    </div>

                    <!-- Status Dropdown -->
                    <select name="status"
                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                        <option value="">جميع الحالات</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد المراجعة
                        </option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>معتمد</option>
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

            <!-- Enhanced Pagination -->
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Fix date inputs placeholder
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

                // Export functionality
                document.getElementById('exportBtn').addEventListener('click', function () {
                    // Get current filters
                    const formData = new FormData(document.getElementById('filterForm'));
                    formData.append('export', 'true');

                    // Convert FormData to URL parameters
                    const params = new URLSearchParams(formData);

                    // Redirect to export route
                    window.location.href = `${window.location.pathname}/export?${params.toString()}`;
                });

                // Real-time search
                let searchTimeout;
                const searchInput = document.querySelector('input[name="search"]');
                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        document.getElementById('filterForm').submit();
                    }, 500);
                });
            });
        </script>
    @endpush
</x-layout>
