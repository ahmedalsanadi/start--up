<!--resources/views/investor/announcements/show.blade.php-->
<x-layout title="تفاصيل الإعلان">
    <div class="space-y-6">

        <!-- Announcement Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">تفاصيل الإعلان</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    تم النشر في {{ $announcement->created_at->format('Y/m/d') }}
                </p>
            </div>
<!-- resources/views/investor/announcements/show.blade.php -->
<div class="flex items-center gap-2">
    @if(!$announcement->is_closed)
        <form action="{{ route('investor.announcements.toggle-closed', $announcement) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                إغلاق الإعلان
            </button>
        </form>
    @else
        <form action="{{ route('investor.announcements.toggle-closed', $announcement) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                فتح الإعلان
            </button>
        </form>
    @endif
</div>
        </div>
        <div class="relative ">
            <!-- Gradient Glow Effect -->
            <div
                class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 ">
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 relative overflow-hidden"
                dir="rtl">
                <!-- Decorative Background Element -->
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-blue-50 dark:bg-blue-900/20 rounded-full -translate-y-32 translate-x-32 blur-3xl">
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">

                    </div>
                </div>

                <!-- Announcement Details Card -->
                <div class="relative">
                    <!-- Investor Profile and Name -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full overflow-hidden ring-2 ring-blue-500 dark:ring-blue-400 ring-offset-2 ring-offset-white dark:ring-offset-gray-800">
                                <img src="{{
    filter_var($announcement->investor->profile_image, FILTER_VALIDATE_URL)
    ? $announcement->investor->profile_image
    : asset('storage/' . $announcement->investor->profile_image)
                        }}" alt="صورة المستثمر" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $announcement->investor->name }}
                                </h3>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    مستثمر
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col items-center gap-4">
                            <!-- created_at -->
                            <div class="flex items-center gap-2">
                                <!-- Lucide Clock Icon -->
                                <i data-lucide="clock" class="w-6 h-6 text-gray-500 dark:text-gray-400"></i>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $announcement->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <!-- Status Badge -->
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $announcement->is_closed ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                {{ $announcement->is_closed ? 'مغلق' : 'عام' }}
                            </span>
                        </div>
                    </div>

                    <!-- Announcement Title and Description -->

                    <div class="mb-6">
                        <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                            {{ $announcement->description }}
                        </p>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <!-- Location -->
                        <div class="my-2">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <i data-lucide="map-pin" class="w-5 h-5 text-blue-500 dark:text-blue-300"></i>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">الموقع</span>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $announcement->location }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Budget -->
                        <div class="my-2">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <i data-lucide="dollar-sign" class="w-5 h-5 text-green-500 dark:text-green-300"></i>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">الميزانية</span>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ number_format($announcement->budget, 2) }} ريال
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div class="my-2">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <i data-lucide="calendar-plus"
                                        class="w-5 h-5 text-purple-500 dark:text-purple-300"></i>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">تاريخ
                                        البداية</span>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ $announcement->start_date->format('Y/m/d') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="my-2">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <i data-lucide="calendar-minus"
                                        class="w-5 h-5 text-yellow-500 dark:text-yellow-300"></i>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">تاريخ
                                        النهاية</span>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ $announcement->end_date->format('Y/m/d') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Approval Status -->
                        <div class="my-2">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <i data-lucide="alert-circle" class="w-5 h-5 text-red-500 dark:text-red-300"></i>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">حالة
                                        الموافقة</span>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ __("announcements.status.{$announcement->approval_status}") }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Closed Status -->
                        <div class="my-2">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <i data-lucide="lock" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">الحالة</span>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ $announcement->is_closed ? 'مغلق' : 'مفتوح' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Categories Section -->
    <div class="relative">

        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 relative overflow-hidden"
            dir="rtl">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">التصنيفات</h2>
            <div class="flex flex-col justify-center gap-2">
                @foreach($announcement->categories as $category)
                    <div>
                        <span class="mt-2 px-3 py-1 bg-purple-900 text-purple-200 rounded-full text-sm line-clamp-1">
                            {{ $category->name }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Timeline Section -->
    <div class="relative">

        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 relative overflow-hidden"
            dir="rtl">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">الجدول الزمني</h2>
            <div class="relative">
                <div class="absolute h-full w-0.5 bg-gray-200 dark:bg-gray-700 right-1.5"></div>
                <div class="space-y-6">
                    <!-- Created At Timeline -->
                    <div class="relative flex items-center">
                        <div class="absolute right-0 h-3 w-3 rounded-full bg-green-500 dark:bg-green-400"></div>
                        <div class="mr-6">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">تم إنشاء الإعلان</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $announcement->created_at->format('Y/m/d H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Approval Status Timeline -->
                    @if($announcement->approval_status !== 'pending')
                        <div class="relative flex items-center">
                            <div class="absolute right-0 h-3 w-3 rounded-full
                                {{ $announcement->approval_status === 'approved' ? 'bg-green-500 dark:bg-green-400' : 'bg-red-500 dark:bg-red-400' }}">
                            </div>
                            <div class="mr-6">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $announcement->approval_status === 'approved' ? 'تمت الموافقة على الإعلان' : 'تم رفض الإعلان' }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $announcement->updated_at->format('Y/m/d H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Rejection Reason or Status Message -->
            <div class="mt-6">
                @if($announcement->approval_status === 'rejected' && $announcement->rejection_reason)
                    <div class="bg-red-50 dark:bg-red-900/10 p-4 rounded-lg border border-red-100 dark:border-red-900/20">
                        <p class="text-sm font-medium text-red-600 dark:text-red-400">سبب الرفض:</p>
                        <p class="text-sm text-red-500 dark:text-red-400 mt-1">
                            {{ $announcement->rejection_reason }}
                        </p>
                    </div>
                @elseif($announcement->approval_status === 'approved')
                    <div class="bg-green-50 dark:bg-green-900/10 p-4 rounded-lg border border-green-100 dark:border-green-900/20">
                        <p class="text-sm font-medium text-green-600 dark:text-green-400">تمت الموافقة على الإعلان من قبل الإدارة.</p>
                    </div>
                @elseif($announcement->approval_status === 'pending')
                    <div class="bg-yellow-50 dark:bg-yellow-900/10 p-4 rounded-lg border border-yellow-100 dark:border-yellow-900/20">
                        <p class="text-sm font-medium text-yellow-600 dark:text-yellow-400">الإعلان قيد المراجعة من قبل الإدارة.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>




        <!-- Ideas Section -->
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 relative overflow-hidden"
            dir="rtl">
            <!-- Section Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <i data-lucide="lightbulb" class="w-5 h-5 text-yellow-500"></i>
                    الأفكار المقدمة
                </h3>
                <span
                    class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">
                    {{ $announcement->ideas->count() }} فكرة
                </span>
            </div>

            <!-- Responsive Table Container -->
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">اسم
                                            الفكرة</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right hidden md:table-cell">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">الوصف
                                            المختصر</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right hidden lg:table-cell">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">تاريخ
                                            الإنشاء</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right hidden lg:table-cell">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">تاريخ
                                            الانتهاء</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">المرحلة</span>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <span
                                            class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">الإجراءات</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($announcement->ideas as $idea)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <!-- Idea Name -->
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
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 md:hidden">
                                                        {{ Str::limit($idea->brief_description, 50) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Brief Description -->
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            <div class="text-sm text-gray-900 dark:text-white line-clamp-2">
                                                {{ $idea->brief_description }}
                                            </div>
                                        </td>

                                        <!-- Created At -->
                                        <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $idea->created_at->format('Y/m/d') }}
                                            </div>
                                        </td>

                                        <!-- Expiry Date -->
                                        <!-- Expiry Date -->
                                        <!-- Expiry Date -->
                                        <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $idea->expiry_date ? $idea->expiry_date->format('Y/m/d') : 'غير محدد' }}
                                            </div>
                                        </td>


                                        <!-- Stage -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <x-stage-badge :stage="$idea->stage" />
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('investor.ideas.show', $idea) }}"
                                                    class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                    <i data-lucide="eye"
                                                        class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                                                </a>
                                                <button type="button" onclick="openUpdateStageModal('{{ $idea->id }}')"
                                                    class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                    <i data-lucide="refresh-cw"
                                                        class="w-5 h-5 text-green-600 dark:text-green-400"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center">
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


</x-layout>
