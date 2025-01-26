<x-layout title="إدارة التسجيلات التجارية">
    <div class="flex flex-col gap-4 px-2">

        <!-- Page Header with Breadcrumb -->
        <div class="flex justify-between items-center mb-6">
            <x-page-header>إدارة التسجيلات التجارية</x-page-header>
            <nav class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <span>لوحة التحكم</span>
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                <span class="text-blue-600 dark:text-blue-400">إدارة التسجيلات التجارية</span>
            </nav>
        </div>

        <!-- Filters Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mt-6">

            <form id="filterForm" action="{{ route('admin.commerical-registrations.index') }}" method="GET" class="space-y-4">
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
            <form id="exportForm" action="{{ route('export', ['type' => 'commercial-registration']) }}" method="POST"
                class="hidden">
                @csrf
                <!-- Hidden Inputs for Filters -->
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                <input type="hidden" name="date_to" value="{{ request('date_to') }}">
            </form>

        </div>

        <!-- Registrations Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Table Header -->
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">قائمة التسجيلات التجارية</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        عدد النتائج: {{ $registrations->total() }}
                    </span>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">المستثمر</th>
                            <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">رقم التسجيل</th>
                            <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">الحالة</th>
                            <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">تاريخ التسجيل</th>
                            <th class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($registrations as $registration)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <!-- Investor Profile Image -->
                                        <x-profile-img
                                            :src="$registration->user->profile_image ?? 'images/default-profile.png'"
                                            :alt="$registration->user->name"
                                            size="sm"
                                        />
                                        <!-- Investor Name and Email -->
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $registration->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $registration->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $registration->registration_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $registration->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $registration->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $registration->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $registration->created_at->format('M d, Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if ($registration->status == 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            مقبول
                                        </span>
                                    @else
                                        <button onclick="openModal('{{ $registration->id }}')"
                                                class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400">
                                            مراجعة
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $registrations->links() }}
            </div>
        </div>
    </div>

<x-commericial-review-modal />
    @push('scripts')


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
                handleExport();
            });
        </script>
    @endpush
</x-layout>
