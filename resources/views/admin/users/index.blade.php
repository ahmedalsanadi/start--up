<x-layout title="إدارة المستخدمين">
    <div class="flex flex-col gap-4 px-2">

        <!-- Page Header with Breadcrumb -->
        <div class="flex justify-between items-center mb-6">
            <x-page-header>إدارة المستخدمين</x-page-header>
            <nav class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <span>لوحة التحكم</span>
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                <span class=" text-blue-600 dark:text-blue-400 ">إدارة المستخدمين</span>
            </nav>
        </div>

        <!-- Stats Cards -->
        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- إجمالي المستخدمين النشطين -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
                </div>
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col gap-1 p-4">
                        <p class="text-gray-950 dark:text-green-200 text-md font-medium truncate">إجمالي المستخدمين
                            النشطين</p>
                        <div class="flex items-center justify-between px-4">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-950 dark:text-green-200">
                                    {{ $statistics['totalActiveUsers'] }}</h3>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-sm opacity-30">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-white to-green-200 dark:from-green-900 dark:to-gray-800 p-3 rounded-full border border-green-300 dark:border-green-700 shadow-inner">
                                    <i data-lucide="users" class="h-6 w-6 text-green-500 dark:text-green-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                    </div>
                </div>
            </div>

            <!-- إجمالي المستخدمين غير النشطين -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
                </div>
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col gap-1 p-4">
                        <p class="text-gray-950 dark:text-red-200 text-md font-medium truncate">إجمالي المستخدمين غير
                            النشطين</p>
                        <div class="flex items-center justify-between px-4">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-950 dark:text-red-200">
                                    {{ $statistics['totalInactiveUsers'] }}</h3>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-sm opacity-30">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-white to-red-200 dark:from-red-900 dark:to-gray-800 p-3 rounded-full border border-red-300 dark:border-red-700 shadow-inner">
                                    <i data-lucide="users" class="h-6 w-6 text-red-500 dark:text-red-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                    </div>
                </div>
            </div>

            <!-- إجمالي المستثمرين -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
                </div>
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col gap-1 p-4">
                        <p class="text-gray-950 dark:text-blue-200 text-md font-medium truncate">إجمالي المستثمرين</p>
                        <div class="flex items-center justify-between px-4">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-950 dark:text-blue-200">
                                    {{ $statistics['totalInvestors'] }}</h3>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-sm opacity-30">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-white to-blue-200 dark:from-blue-900 dark:to-gray-800 p-3 rounded-full border border-blue-300 dark:border-blue-700 shadow-inner">
                                    <i data-lucide="users" class="h-6 w-6 text-blue-500 dark:text-blue-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600 dark:to-gray-800">
                    </div>
                </div>
            </div>

            <!-- إجمالي رواد الأعمال -->
            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
                </div>
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col gap-1 p-4">
                        <p class="text-gray-950 dark:text-yellow-200 text-md font-medium truncate">إجمالي رواد الأعمال
                        </p>
                        <div class="flex items-center justify-between px-4">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-950 dark:text-yellow-200">
                                    {{ $statistics['totalEntrepreneurs'] }}</h3>
                            </div>
                            <div class="relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-sm opacity-30">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-white to-yellow-200 dark:from-yellow-900 dark:to-gray-800 p-3 rounded-full border border-yellow-300 dark:border-yellow-700 shadow-inner">
                                    <i data-lucide="users" class="h-6 w-6 text-yellow-500 dark:text-yellow-300"></i>
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
            <form id="filterForm" action="{{ route('admin.users.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div class="relative">
                        <span class="absolute right-3 top-2.5 text-gray-400">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pr-10 pl-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
                            placeholder="البحث عن مستخدم...">
                    </div>

                    <!-- User Type Dropdown -->
                    <select name="user_type"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                        <option value="">جميع الأنواع</option>
                        <option value="1" {{ request('user_type') == 1 ? 'selected' : '' }}>مدير</option>
                        <option value="2" {{ request('user_type') == 2 ? 'selected' : '' }}>مستثمر</option>
                        <option value="3" {{ request('user_type') == 3 ? 'selected' : '' }}>رائد أعمال</option>
                    </select>

                    <!-- Active Status Dropdown -->
                    <select name="is_active"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400">
                        <option value="">جميع الحالات</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>غير نشط</option>
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
                        <a href="{{ route('admin.users.index') }}"
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
            <form id="exportForm" action="{{ route('export', ['type' => 'user']) }}" method="POST" class="hidden">
                @csrf
                <!-- Hidden Inputs for Filters -->
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="user_type" value="{{ request('user_type') }}">
                <input type="hidden" name="is_active" value="{{ request('is_active') }}">
            </form>
        </div>
        <!-- Users Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Table Header -->
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">قائمة المستخدمين</h3>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        عدد النتائج: {{ $users->total() }}
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
                                المستخدم</th>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                البريد الإلكتروني</th>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                رقم الهاتف</th>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                النوع</th>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الحالة</th>
                            <th
                                class="px-6 py-3 text-right text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('admin.users.show', $user) }}" class="flex items-center gap-2">

                                        <x-profile-img :src="$user->profile_image ?? 'images/default-profile.png'"
                                            :alt="$user->name" size="sm" />

                                        <div class=" text-sm text-gray-900 dark:text-white ">

                                            {{ $user->name }}
                                        </div>
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $user->phone_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    @if($user->user_type == 1)
                                        مدير
                                    @elseif($user->user_type == 2)
                                        مستثمر
                                    @else
                                        رائد أعمال
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-badge :type="$user->is_active ? 'success' : 'danger'" :label="$user->is_active ? 'نشط' : 'غير نشط'" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">

                                    <!-- Toggle Active/Inactive -->
                                    <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="{{ $user->is_active ? 'bg-red-600 hover:bg-red-500' : 'bg-green-500 hover:bg-green-600' }} text-white font-bold py-2 px-4 rounded-full flex items-center">
                                            @if($user->is_active)

                                                <span>تعطيل</span> <!-- Inactivate in Arabic -->
                                            @else

                                                <span>تفعيل</span> <!-- Activate in Arabic -->
                                            @endif
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    لا توجد مستخدمين متاحين
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        </div>
    </div>


    @push('scripts')
        <script>

            function handleExport() {
                const exportBtn = document.getElementById('exportBtn');
                if (exportBtn) {
                    exportBtn.addEventListener('click', function () {
                        const filterForm = document.getElementById('filterForm');
                        const search = filterForm.querySelector('input[name="search"]').value;
                        const userType = filterForm.querySelector('select[name="user_type"]').value;
                        const isActive = filterForm.querySelector('select[name="is_active"]').value;

                        const exportForm = document.getElementById('exportForm');
                        exportForm.querySelector('input[name="search"]').value = search;
                        exportForm.querySelector('input[name="user_type"]').value = userType;
                        exportForm.querySelector('input[name="is_active"]').value = isActive;

                        exportForm.submit();
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                handleExport();
            });
        </script>
    @endpush


</x-layout>
