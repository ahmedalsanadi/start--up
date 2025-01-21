<x-layout title="تفاصيل الإعلان">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <!-- Header Section -->
<!-- Header Section -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
    <div class="p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <!-- Left Side: Announcement Info -->
            <div class="space-y-2">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <!-- Approval Status Badge -->
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        @if($announcement->approval_status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        @elseif($announcement->approval_status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                        @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                        @endif">
                        {{ __($announcement->approval_status) }}
                    </span>
                    <!-- Published Date -->
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        تم النشر: {{ $announcement->created_at->format('Y/m/d') }}
                    </span>
                </div>
                <!-- Announcement Title -->
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    إعلان استثماري #{{ $announcement->id }}
                </h1>
            </div>

            <!-- Right Side: Close Button -->
            <button onclick="window.location.href='{{ route('investor.announcements.index') }}'"
                    class="rounded-full p-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Key Metrics Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
    <!-- Budget Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">الميزانية</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                    {{ number_format($announcement->budget) }} ريال
                </p>
            </div>
            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Days Remaining Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">الأيام المتبقية</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                    {{ $statistics['days_remaining'] }} يوم
                </p>
            </div>
            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Ideas Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">عدد الأفكار</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                    {{ $statistics['total_ideas'] }}
                </p>
            </div>
            <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Approved Ideas Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">الأفكار المعتمدة</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white mt-1">
                    {{ $statistics['last_decision'] }}
                </p>
            </div>
            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
    </div>
</div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">وصف الإعلان</h2>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
                            {{ $announcement->description }}
                        </p>
                    </div>
                </div>

                <!-- Ideas Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">الأفكار المقدمة</h2>

                        @forelse($announcement->ideas as $idea)
                            <div class="border-b border-gray-200 dark:border-gray-700 last:border-0 py-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="text-md font-semibold text-gray-800 dark:text-white">
                                            {{ $idea->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            {{ Str::limit($idea->brief_description, 100) }}
                                        </p>
                                        <div class="flex flex-wrap items-center gap-4 mt-2">
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                الميزانية المطلوبة: {{ number_format($idea->budget) }} ريال
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $idea->location }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <span class="px-3 py-1 text-xs rounded-full
                                            @php
                                                $latestStage = $idea->stages->sortByDesc('changed_at')->first();
                                            @endphp
                                            @if($latestStage?->stage === 'initial_approve')
                                                bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                            @elseif($latestStage?->stage === 'under_review')
                                                bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                            @elseif($latestStage?->stage === 'last_decision')
                                                bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                            @endif">
                                            {{ __($latestStage?->stage ?? 'new') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4 flex justify-end">
                                    <button
                                        onclick="window.location.href='{{ route('investor.ideas.show', $idea) }}'"
                                        class="px-4 py-2 text-sm bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors"
                                    >
                                        عرض التفاصيل
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">لا توجد أفكار مقدمة حتى الآن</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column - Additional Info -->
            <div class="space-y-6">
                <!-- Categories Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">التصنيفات</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($announcement->categories as $category)
                                <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-sm">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Ideas Progress -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">تقدم الأفكار</h2>
                        <div class="space-y-4">
                            @foreach([
                                ['label' => 'موافقة مبدئية', 'value' => $statistics['initial_approve'], 'color' => 'blue'],
                                ['label' => 'قيد المراجعة', 'value' => $statistics['under_review'], 'color' => 'yellow'],
                                ['label' => 'القرار النهائي', 'value' => $statistics['last_decision'], 'color' => 'green']
                            ] as $progress)
                                <div>
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $progress['label'] }}</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $progress['value'] }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-{{ $progress['color'] }}-600 h-2 rounded-full transition-all duration-300"
                                             style="width: {{ $statistics['total_ideas'] ? ($progress['value'] / $statistics['total_ideas'] * 100) : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">الجدول الزمني</h2>
                        <div class="relative">
                            <div class="absolute h-full w-0.5 bg-gray-200 dark:bg-gray-700 right-1.5"></div>
                            <div class="space-y-6">
                                <div class="relative flex items-center">
                                    <div class="absolute right-0 h-3 w-3 rounded-full bg-green-500 dark:bg-green-400"></div>
                                    <div class="mr-6">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">تم إنشاء الإعلان</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $announcement->created_at->format('Y/m/d H:i') }}
                                        </p>
                                    </div>
                                </div>

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
                                            @if($announcement->rejection_reason)
                                                <p class="text-xs text-red-500 mt-1">
                                                    {{ $announcement->rejection_reason }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
