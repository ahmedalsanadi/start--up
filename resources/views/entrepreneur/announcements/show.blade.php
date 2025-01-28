<!--resources/views/investor/announcements/show.blade.php-->
<x-layout title="تفاصيل الإعلان">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">بيانات الإعلان</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    تم النشر في {{ $announcement->created_at->format('Y/m/d') }}
                </p>
            </div>
        </div>

        <!-- Main Content Section -->

        <!-- Project Overview Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
            <div class="flex items-center space-x-4 rtl:space-x-reverse mb-6">
                <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                    <i data-lucide="clipboard-list" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">تفاصيل المشروع</h3>
            </div>
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-8">
                {{ $announcement->description }}
            </p>

            <!-- Project Dates and Budget -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                        <i data-lucide="calendar" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ البدء</h4>
                        <p class="text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($announcement->start_date)->format('Y/m/d') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="p-3 bg-red-100 dark:bg-red-900/30 rounded-full">
                        <i data-lucide="calendar-x" class="w-6 h-6 text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الانتهاء</h4>
                        <p class="text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($announcement->end_date)->format('Y/m/d') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                        <i data-lucide="map-pin" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">الموقع</h4>
                        <p class="text-gray-900 dark:text-white">{{ $announcement->location }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-full">
                        <i data-lucide="wallet" class="w-6 h-6 text-yellow-600 dark:text-yellow-400"></i>
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

        <!-- Dates and Timeline Card -->


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                <div class="flex items-center space-x-4 rtl:space-x-reverse mb-6">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <i data-lucide="tags" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">التصنيفات</h2>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach($announcement->categories as $category)
                        <span
                            class="px-4 py-2 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
                <div class="flex items-center space-x-4 rtl:space-x-reverse mb-6">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/30 rounded-full">
                        <i data-lucide="clock" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">الجدول الزمني</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                            <i data-lucide="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">تاريخ الإنشاء</h4>
                            <p class="text-gray-900 dark:text-white">
                                {{ $announcement->created_at->format('Y/m/d H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 rtl:space-x-reverse">
                        <div
                            class="p-3 {{ $announcement->approval_status === 'approved' ? 'bg-green-100 dark:bg-green-900/30' : 'bg-red-100 dark:bg-red-900/30' }} rounded-full">
                            <i data-lucide="{{ $announcement->approval_status === 'approved' ? 'check' : 'x' }}"
                                class="w-6 h-6 {{ $announcement->approval_status === 'approved' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">حالة الموافقة</h4>
                            <p class="text-gray-900 dark:text-white">
                                {{ $announcement->approval_status === 'approved' ? 'تمت الموافقة' : 'تم الرفض' }}
                            </p>
                        </div>
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
                    أفكاري المقدمة لهذا الإعلان
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
                                                <a href="{{ route('entrepreneur.ideas.show', $idea) }}"
                                                    class="p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                    <i data-lucide="eye"
                                                        class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                                                </a>

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
