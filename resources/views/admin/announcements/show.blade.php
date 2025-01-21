<x-layout title="تفاصيل الإعلان">
    <div class="flex flex-col gap-6 px-2">
        <!-- Header Section with Status Badge -->
        <div class="flex justify-between items-center">
            <x-page-header>تفاصيل الإعلان</x-page-header>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
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
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">تفاصيل المشروع</h3>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $announcement->description }}
                        </p>
                    </div>
                </div>

                <!-- Project Details Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
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
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ البدء</h4>
                                        <p class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($announcement->start_date)->format('Y/m/d') }}</p>
                                    </div>
                                </div>
                                <!-- End Date -->
                                <div class="relative flex items-center">
                                    <div class="absolute w-4 h-4 bg-red-500 rounded-full left-8"></div>
                                    <div class="mr-16">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الانتهاء</h4>
                                        <p class="text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($announcement->end_date)->format('Y/m/d') }}</p>
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
                                    <p class="text-gray-900 dark:text-white">{{ number_format($announcement->budget, 2) }} ريال</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">الأقسام</h3>
                        <div class="flex flex-wrap gap-2">
                            @forelse($announcement->categories as $category)
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                                    {{ $category->name }}
                                </span>
                            @empty
                                <p class="text-gray-500 dark:text-gray-400">لا توجد أقسام مضافة</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Ideas Section -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">الأفكار المعروضة</h3>
                        <!-- Placeholder for Ideas - To be implemented -->
                        <div class="text-center py-8">
                            <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="lightbulb" class="w-8 h-8 text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400">لم يتم تقديم أي أفكار بعد</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Information -->
            <div class="space-y-6">
                <!-- Investor Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">معلومات المستثمر</h3>
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                                    <i data-lucide="user" class="w-6 h-6 text-gray-500 dark:text-gray-400"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-gray-900 dark:text-white font-medium">{{ $announcement->investor->name }}</h4>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $announcement->investor->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">إجراءات الإدارة</h3>
                        @if($announcement->approval_status === 'pending')
                            <div class="space-y-4">
                                <form action="{{ route('admin.announcements.update-status', $announcement) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="approval_status" value="approved">
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                        الموافقة على الإعلان
                                    </button>
                                </form>
                                <button onclick="openRejectModal()" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                    رفض الإعلان
                                </button>
                            </div>
                        @elseif($announcement->approval_status === 'rejected')
                            <div class="bg-red-50 dark:bg-red-900/30 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-red-800 dark:text-red-300 mb-2">سبب الرفض:</h4>
                                <p class="text-red-700 dark:text-red-200">{{ $announcement->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dates Information -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">معلومات التواريخ</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الإنشاء</h4>
                                <p class="text-gray-900 dark:text-white">{{ $announcement->created_at->format('Y/m/d H:i') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">آخر تحديث</h4>
                                <p class="text-gray-900 dark:text-white">{{ $announcement->updated_at->format('Y/m/d H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <form id="rejectForm" action="{{ route('admin.announcements.update-status', $announcement->id) }}" method="POST">
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
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-layout>
