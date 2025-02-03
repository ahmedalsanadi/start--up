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
            <!-- إجمالي الإعلانات -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
                </div>
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col gap-1 p-4">
                        <p class="text-gray-950 dark:text-blue-200 text-md font-medium truncate">إجمالي الإعلانات</p>
                        <div class="flex items-center justify-between px-4">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-950 dark:text-blue-200">
                                    {{ $total_announcements }}
                                </h3>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-sm opacity-30">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-white to-blue-200 dark:from-blue-900 dark:to-gray-800 p-3 rounded-full border border-blue-300 dark:border-blue-700 shadow-inner">
                                    <i data-lucide="megaphone" class="h-6 w-6 text-blue-500 dark:text-blue-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                    </div>
                </div>
            </div>

            <!-- إعلانات قيد المراجعة -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
                </div>
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col gap-1 p-4">
                        <p class="text-gray-950 dark:text-yellow-200 text-md font-medium truncate">إعلانات قيد المراجعة
                        </p>
                        <div class="flex items-center justify-between px-4">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-950 dark:text-yellow-200">
                                    {{ $total_pending_announcements }}
                                </h3>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-sm opacity-30">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-white to-yellow-200 dark:from-yellow-900 dark:to-gray-800 p-3 rounded-full border border-yellow-300 dark:border-yellow-700 shadow-inner">
                                    <i data-lucide="clock" class="h-6 w-6 text-yellow-500 dark:text-yellow-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                    </div>
                </div>
            </div>

            <!-- الإعلانات النشطة -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
                </div>
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col gap-1 p-4">
                        <p class="text-gray-950 dark:text-green-200 text-md font-medium truncate">الإعلانات النشطة</p>
                        <div class="flex items-center justify-between px-4">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-950 dark:text-green-200">
                                    {{ $total_active_announcements }}
                                </h3>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-sm opacity-30">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-white to-green-200 dark:from-green-900 dark:to-gray-800 p-3 rounded-full border border-green-300 dark:border-green-700 shadow-inner">
                                    <i data-lucide="check-circle"
                                        class="h-6 w-6 text-green-500 dark:text-green-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                    </div>
                </div>
            </div>

            <!-- الإعلانات المرفوضة -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
                </div>
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col gap-1 p-4">
                        <p class="text-gray-950 dark:text-blue-200 text-md font-medium truncate">الإعلانات المرفوضة</p>
                        <div class="flex items-center justify-between px-4">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-950 dark:text-blue-200">
                                    {{ $total_rejected_announcements }}
                                </h3>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-sm opacity-30">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-white to-blue-200 dark:from-blue-900 dark:to-gray-800 p-3 rounded-full border border-blue-300 dark:border-blue-700 shadow-inner">
                                    <i data-lucide="x-circle" class="h-6 w-6 text-blue-500 dark:text-blue-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mt-6">
            <!-- Filter Form -->
            <form id="filterForm" action="{{ route('admin.announcements.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                </div>
                <div class="flex items-center justify-center gap-4 mt-4">


                </div>

                <div class="flex items-center justify-center gap-4 mt-4">
                    <!-- Approval Status Dropdown -->
                    <div class="relative w-full">
                        <select name="approval_status"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                            <option value="">جميع الحالات</option>
                            <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>قيد
                                المراجعة</option>
                            <option value="approved" {{ request('approval_status') == 'approved' ? 'selected' : '' }}>
                                مقبولة
                            </option>
                            <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>
                                مرفوضة
                            </option>
                        </select>
                        <label
                            class="absolute -top-3 right-2 text-xs text-gray-600 bg-white dark:text-gray-400 dark:bg-gray-800 px-2 py-0.5 rounded-full">
                            حالة
                            الموافقة
                        </label>

                    </div>

                    <!-- Status Dropdown -->
                    <div class="relative w-full">
                        <select name="status"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                            <option value="">جميع الحالات</option>
                            <option value="in-progress" {{ request('status') == 'in-progress' ? 'selected' : '' }}>
                                جاري
                            </option>
                            <option value="compeleted" {{ request('status') == 'compeleted' ? 'selected' : '' }}>

                                مكتملة
                            </option>
                            <option value="deleted_by_investor" {{ request('status') == 'deleted_by_investor' ? 'selected' : '' }}>

                                محذوفة
                            </option>


                        </select>
                        <label
                            class="absolute -top-3 right-2 text-xs text-gray-600 bg-white dark:text-gray-400 dark:bg-gray-800 px-2 py-0.5 rounded-full">
                            حالة الإعلان
                        </label>
                    </div>

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
                <input type="hidden" name="approval_status" value="{{ request('approval_status') }}">
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
                                class="px-4 py-2 text-right text-sm font-semibold text-gray-500 dark:text-gray-100 uppercase tracking-wide">
                                المستثمر</th>
                            <th
                                class="px-4 py-2 text-right text-sm font-semibold text-gray-500 dark:text-gray-100 uppercase tracking-wide">
                                الوصف</th>
                            <th class="px-4 py-2 text-right text-sm font-medium uppercase tracking-wide">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                        <span class="px-2 py-1 text-pink-600 dark:text-pink-200">الموقع</span>
                                    </div>
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-1">
                                        <div class="flex items-center gap-2">
                                            <i data-lucide="dollar-sign"
                                                class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                            <span class="px-2 py-1 text-pink-600 dark:text-pink-200">الميزانية</span>
                                        </div>
                                    </div>
                                </div>
                            </th>

                            <th class="px-4 py-2 text-right text-xs font-medium uppercase tracking-wide">
                                <span class="px-2 py-1 text-pink-600 dark:text-pink-200">تاريخ الإنشاء</span>
                            </th>


                            <th class="px-4 py-2 text-right text-xs font-medium uppercase tracking-wide">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="lightbulb" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                        <span class="px-2 py-1 text-pink-600 dark:text-pink-200">حالة الإعلان</span>
                                    </div>
                                    <div class="border-t border-gray-200 dark:border-gray-700 pt-1">
                                        <div class="flex items-center gap-2">
                                            <i data-lucide="check-circle"
                                                class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                            <span class="px-2 py-1 text-pink-600 dark:text-pink-200">حالة
                                                الموافقة</span>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($announcements as $announcement)
                                                <tr>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="flex items-center gap-3">
                                        
                                                            <x-profile-img src="{{$announcement->investor->profile_image}}" alt="User Avatar" size="sm" />
                                                            <span class="text-xs font-medium text-gray-900 dark:text-white">
                                                                {{ $announcement->investor->name }} </span>
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="text-xs font-medium text-gray-900 dark:text-white truncate">
                                                            {{ Str::words($announcement->description, 6) }}
                                                        </div>
                                                    </td>

                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="flex flex-col gap-2">
                                                            <div class="flex items-center gap-2">
                                                                <i data-lucide="map-pin" class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                                                <span
                                                                    class="text-xs text-pink-600 dark:text-pink-200">{{ $announcement->location }}</span>
                                                            </div>
                                                            <div class="border-t border-gray-200 dark:border-gray-700 pt-1">
                                                                <div class="flex items-center gap-2">
                                                                    <i data-lucide="dollar-sign"
                                                                        class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                                                    <span class="text-xs text-pink-600 dark:text-pink-200">
                                                                        {{ number_format($announcement->budget, 2) }} ريال
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-5 py-3 whitespace-nowrap">
                                                        <div class="text-xs text-gray-900 dark:text-white">
                                                            {{ $announcement->created_at->format('M d, Y') }}
                                                        </div>
                                                    </td>


                                                    <td class="px-4 py-4 whitespace-nowrap text-xs font-normal">
                                                        <div class="flex flex-col gap-1">
                                                            <!-- Idea Status -->
                                                            <div class="group">
                                                                <div class="flex items-center gap-4">
                                                                    <i data-lucide="lightbulb"
                                                                        class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                                                    @php
                                                                        $status = $announcement->status;
                                                                        $statusColors = [
                                                                            'in-progress' => 'bg-indigo-200 text-indigo-800 dark:bg-indigo-700 dark:text-indigo-300',
                                                                            'completed' => 'bg-teal-200 text-teal-800 dark:bg-teal-700 dark:text-teal-300',
                                                                            'deleted_by_investor' => 'bg-orange-200 text-orange-800 dark:bg-orange-700 dark:text-orange-300',
                                                                            'deleted_by_entrepreneur' => 'bg-rose-200 text-rose-800 dark:bg-rose-700 dark:text-rose-300',
                                                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                                                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                                                            'expired' => 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                                        ];
                                                                        $classes = $statusColors[$status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
                                                                    @endphp
                                                                    <span class="px-4 py-1 text-xs rounded-full {{ $classes }}">
                                                                        {{ __('ideas.status.' . $status) }}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <!-- Approval Status -->

                                                            <div class="group border-t border-gray-200 dark:border-gray-700 pt-1">
                                                                <div class="flex items-center gap-4">
                                                                    <i data-lucide="check-circle"
                                                                        class="w-4 h-4 text-blue-600 dark:text-blue-400"></i>
                                                                    @php
                                                                        $approvalStatus = $announcement->approval_status;
                                                                        $approvalColors = [
                                                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                                                        ];
                                                                        $approvalClasses = $approvalColors[$approvalStatus] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
                                                                    @endphp
                                                                    <span class="px-4 py-1 text-xs rounded-full {{ $approvalClasses }}">
                                                                        {{ __('ideas.status.' . $approvalStatus) }}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-nowrap text-left text-xs font-normal">
                                                        <div class="flex items-center justify-center gap-3">
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
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <!-- Modal Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            سبب الرفض
                        </h3>
                        <button onclick="closeRejectModal()"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form id="rejectForm" action="" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="approval_status" value="rejected">

                        <!-- Rejection Reason Textarea -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                أدخل سبب الرفض
                            </label>
                            <textarea name="rejection_reason"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition duration-200"
                                rows="4" placeholder="أدخل سبب الرفض..." required></textarea>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                        إلغاء
                    </button>
                    <button type="submit" form="rejectForm"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition duration-200">
                        تأكيد الرفض
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


            function handleExport() {
                const exportBtn = document.getElementById('exportBtn');
                if (exportBtn) {
                    exportBtn.addEventListener('click', function () {

                        const filterForm = document.getElementById('filterForm');
                        const search = filterForm.querySelector('input[name="search"]').value;
                        const status = filterForm.querySelector('select[name="status"]').value;
                        const approvalStatus = filterForm.querySelector('select[name="approval_status"]').value;
                        const dateFrom = filterForm.querySelector('input[name="date_from"]').value;
                        const dateTo = filterForm.querySelector('input[name="date_to"]').value;

                        const exportForm = document.getElementById('exportForm');
                        exportForm.querySelector('input[name="search"]').value = search;
                        exportForm.querySelector('input[name="status"]').value = status;
                        exportForm.querySelector('input[name="approval_status"]').value = approvalStatus;
                        exportForm.querySelector('input[name="date_from"]').value = dateFrom;
                        exportForm.querySelector('input[name="date_to"]').value = dateTo;

                        exportForm.submit();
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                handleDateInputs();
                // handleRealTimeSearch();
                handleExport();
            });
        </script>
    @endpush
</x-layout>
