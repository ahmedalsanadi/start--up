<x-layout title="تفاصيل الإعلان">
    <div class="flex flex-col gap-6 px-2">
        <!-- Header Section with Status Badge -->
        <div class="flex justify-between items-center">
            <x-page-header>بيانات الإعلان</x-page-header>
            <span
                class="px-4 py-2 rounded-full text-sm font-semibold
                {{ $announcement->approval_status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : '' }}
                {{ $announcement->approval_status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : '' }}
                {{ $announcement->approval_status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300' : '' }}">
                {{ __('announcements.status.' . $announcement->approval_status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description Card -->
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">تفاصيل المشروع</h3>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $announcement->description }}
                        </p>
                    </div>
                </div>

                <!-- Project Details Card -->
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6 space-y-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">معلومات المشروع</h3>

                        <!-- Timeline -->
                        <div class="relative">
                            <div class="absolute h-full w-0.5 bg-gray-200 dark:bg-gray-700 left-9"></div>
                            <div class="space-y-8">
                                <!-- Start Date -->
                                <div class="relative flex items-center">
                                    <div class="absolute w-4 h-4 bg-blue-500 rounded-full left-8"></div>
                                    <div class="mr-16">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ البدء
                                        </h4>
                                        <p class="text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($announcement->start_date)->format('Y/m/d') }}
                                        </p>
                                    </div>
                                </div>
                                <!-- End Date -->
                                <div class="relative flex items-center">
                                    <div class="absolute w-4 h-4 bg-red-500 rounded-full left-8"></div>
                                    <div class="mr-16">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الانتهاء
                                        </h4>
                                        <p class="text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($announcement->end_date)->format('Y/m/d') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location and Budget -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <div class="flex-shrink-0">
                                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                                        <i data-lucide="map-pin" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">الموقع</h4>
                                    <p class="text-gray-900 dark:text-white">{{ $announcement->location }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                <div class="flex-shrink-0">
                                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                                        <i data-lucide="wallet" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">الميزانية</h4>
                                    <p class="text-gray-900 dark:text-white">
                                        {{ number_format($announcement->budget, 2) }} ريال
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">الأقسام</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($announcement->categories as $category)
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400">لا توجد أقسام مضافة</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Information -->
            <div class="space-y-6">
                <!-- Investor Information -->
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">معلومات المستثمر</h3>
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0">
                                <!-- Investor Profile Image -->

                                <x-profile-img src="{{$announcement->investor->profile_image}}" alt="User Avatar" size="md" />
                            </div>
                            <div>
                                <h4 class="text-gray-900 dark:text-white font-medium">
                                    {{ $announcement->investor->name }}
                                </h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $announcement->investor->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Actions -->
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">إجراءات الإدارة</h3>
                        @if($announcement->approval_status === 'pending')
                            <div class="space-y-4">
                                <form action="{{ route('admin.announcements.update-status', $announcement) }}"
                                    method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="approval_status" value="approved">
                                    <button type="submit"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                        الموافقة على الإعلان
                                    </button>
                                </form>
                                <button onclick="openRejectModal()"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                    رفض الإعلان
                                </button>
                            </div>
                        @elseif($announcement->approval_status === 'rejected')
                            <div class="bg-red-50 dark:bg-red-900/30 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-red-800 dark:text-red-300 mb-2">سبب الرفض:</h4>
                                <p class="text-red-700 dark:text-red-200">{{ $announcement->rejection_reason }}</p>
                            </div>
                        @elseif($announcement->approval_status === 'approved')
                            <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-8">
                                <h4 class="text-md font-medium text-green-800 dark:text-green-300 mb-2">حالة الإعلان:</h4>
                                <p class="text-green-700 dark:text-green-200">تمت الموافقة على هذا الإعلان.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dates Information -->
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">معلومات التواريخ</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الإنشاء</h4>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $announcement->created_at->format('Y/m/d H:i') }}
                                </p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">آخر تحديث</h4>
                                <p class="text-gray-900 dark:text-white">
                                    {{ $announcement->updated_at->format('Y/m/d H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ideas Section -->
        <div
            class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">

            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <i data-lucide="lightbulb" class="w-5 h-5 text-lime-400"></i>
                        الأفكار المقدمة
                    </h3>
                    <span
                        class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">
                        {{ $announcement->ideas->count() }} فكرة
                    </span>
                </div>
            </div>

            <!-- Responsive Table Container -->
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800/50">
                                <tr>
                                    <!-- الرائد (Entrepreneur) -->
                                    <th scope="col" class="px-6 py-3 text-right">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            الرائد
                                        </span>
                                    </th>

                                    <!-- اسم الفكرة (Idea Name) -->
                                    <th scope="col" class="px-6 py-3 text-right">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            اسم الفكرة
                                        </span>
                                    </th>

                                    <!-- تاريخ الإنشاء (Creation Date) -->
                                    <th scope="col" class="px-6 py-3 text-right hidden lg:table-cell">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            تاريخ الإنشاء
                                        </span>
                                    </th>

                                    <!-- تاريخ الانتهاء (Expiration Date) -->
                                    <th scope="col" class="px-6 py-3 text-right hidden lg:table-cell">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            تاريخ الانتهاء
                                        </span>
                                    </th>

                                    <!-- حالة الموافقة (Approval Status) -->
                                    <th scope="col" class="px-6 py-3 text-right">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            حالة الموافقة
                                        </span>
                                    </th>

                                    <!-- الحالة (Status) -->
                                    <th scope="col" class="px-6 py-3 text-right">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            الحالة
                                        </span>
                                    </th>

                                    <!-- الإجراءات (Actions) -->
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            الإجراءات
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($announcement->ideas as $idea)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <!-- الرائد (Entrepreneur) -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0">
                                                        <x-profile-img src="{{$idea->entrepreneur->profile_image}}" alt="User Avatar" size="sm" />
                                                </div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $idea->entrepreneur->name }}
                                                </div>
                                            </div>
                                        </td>

                                        <!-- اسم الفكرة (Idea Name) -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                                    <span
                                                        class="text-white text-sm font-bold">{{ substr($idea->name, 0, 1) }}</span>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $idea->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- تاريخ الإنشاء (Creation Date) -->
                                        <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $idea->created_at->format('Y/m/d') }}
                                            </div>
                                        </td>

                                        <!-- تاريخ الانتهاء (Expiration Date) -->
                                        <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $idea->expiry_date ? $idea->expiry_date->format('Y/m/d') : 'غير محدد' }}
                                            </div>
                                        </td>

                                        <!-- حالة الموافقة (Approval Status) -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :type="$idea->approval_status" :label="__('ideas.status.' . $idea->approval_status)" />
                                        </td>

                                        <!-- الحالة (Status) -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-badge :type="$idea->status" :label="__('ideas.status.' . $idea->status)" />
                                        </td>


                                        <!-- الإجراءات (Actions) -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- View Button (Always Visible) -->
                                                <a href="{{ route('admin.ideas.show', $idea) }}"
                                                    class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                    <i data-lucide="eye"
                                                        class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                                                </a>

                                                @if($idea->approval_status === 'pending')
                                                    <!-- Pending: Show Approve and Reject Buttons -->
                                                    <!-- Approve Button -->
                                                    <form action="{{ route('admin.ideas.update-status', $idea) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="approval_status" value="approved">
                                                        <button type="submit"
                                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                            <i data-lucide="check-circle"
                                                                class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Reject Button -->
                                                    <form action="{{ route('admin.ideas.update-status', $idea) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="approval_status" value="rejected">
                                                        <button type="submit"
                                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                            <i data-lucide="x-circle"
                                                                class="w-5 h-5 text-red-600 dark:text-red-400"></i>
                                                        </button>
                                                    </form>

                                                @elseif($idea->approval_status === 'rejected')
                                                    <!-- Rejected: Show Approve Button -->
                                                    <!-- Approve Button -->
                                                    <form action="{{ route('admin.ideas.update-status', $idea) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="approval_status" value="approved">
                                                        <button type="submit"
                                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                            <i data-lucide="check-circle"
                                                                class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                                                        </button>
                                                    </form>

                                                @elseif($idea->approval_status === 'approved')
                                                    <!-- Approved: Show Reject Button -->
                                                    <!-- Reject Button -->
                                                    <form action="{{ route('admin.ideas.update-status', $idea) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="approval_status" value="rejected">
                                                        <button type="submit"
                                                            class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                            <i data-lucide="x-circle"
                                                                class="w-5 h-5 text-red-600 dark:text-red-400"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                    <i data-lucide="lightbulb"
                                                        class="w-8 h-8 text-gray-400 dark:text-gray-500"></i>
                                                </div>
                                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-1">لا توجد
                                                    أفكار بعد</h3>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">لم يتم تقديم أي أفكار
                                                    لهذا الإعلان حتى الآن</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
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
                            <form id="rejectForm"
                                action="{{ route('admin.announcements.update-status', $announcement->id) }}"
                                method="POST">
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
            function openRejectModal() {
                document.getElementById('rejectModal').classList.remove('hidden');
            }

            function closeRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
            }
        </script>
    @endpush
</x-layout>
