<!--resources/views/investor/ideas/show.blade.php-->
<!-- show detailed idea info related to specific announcement with appility to manage stages-->


<!-- resources/views/investor/ideas/show.blade.php -->
<x-layout title="تفاصيل الفكرة">
    <div class="space-y-6">
        <!-- Idea Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">تفاصيل الفكرة</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    تم النشر في {{ $idea->created_at->format('Y/m/d') }}
                </p>
            </div>
        </div>

        <x-card-gradient-bg>
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 dark:bg-blue-900/20 rounded-full -translate-y-32 translate-x-32 blur-3xl"></div>

            <!-- Idea Details Card -->
            <div class="relative">
                <!-- Entrepreneur Profile and Name -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <x-profile-img src="{{ $idea->entrepreneur->profile_image }}" alt="صورة رائد الأعمال" />
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $idea->entrepreneur->name }}
                            </h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                رائد أعمال
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <!-- Created At -->
                        <div class="flex items-center gap-2">
                            <i data-lucide="clock" class="w-6 h-6 text-gray-500 dark:text-gray-400"></i>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $idea->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <!-- Status Badge -->
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $idea->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                            {{ $idea->is_active ? 'نشطة' : 'غير نشطة' }}
                        </span>
                    </div>
                </div>

                <!-- Idea Title and Description -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $idea->name }}</h3>
                    <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                        {{ $idea->brief_description }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed mt-4">
                        {{ $idea->detailed_description }}
                    </p>
                </div>

                <!-- Idea Image -->
                @if ($idea->image)
                    <div class="mb-6">
                        <img src="{{ filter_var($idea->image, FILTER_VALIDATE_URL) ? $idea->image : asset('storage/' . $idea->image) }}"
                             alt="صورة الفكرة"
                             class="w-full h-64 object-cover rounded-lg">
                    </div>
                @endif

                <!-- Idea Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    @foreach ([
                        ['icon' => 'map-pin', 'label' => 'الموقع', 'value' => $idea->location, 'iconColor' => 'text-blue-500 dark:text-blue-300'],
                        ['icon' => 'dollar-sign', 'label' => 'الميزانية', 'value' => number_format($idea->budget, 2) . ' ريال', 'iconColor' => 'text-green-500 dark:text-green-300'],
                        ['icon' => 'lightbulb', 'label' => 'نوع الفكرة', 'value' => $idea->idea_type === 'creative' ? 'إبداعية' : 'تقليدية', 'iconColor' => 'text-purple-500 dark:text-purple-300'],
                        ['icon' => 'calendar', 'label' => 'تاريخ الانتهاء', 'value' => $idea->expiry_date ? $idea->expiry_date->format('Y/m/d') : 'غير محدد', 'iconColor' => 'text-yellow-500 dark:text-yellow-300'],
                        ['icon' => 'alert-circle', 'label' => 'حالة الموافقة', 'value' => __("ideas.status.{$idea->approval_status}"), 'iconColor' => 'text-red-500 dark:text-red-300'],
                        ['icon' => 'trending-up', 'label' => 'المرحلة', 'value' => __("ideas.stages.{$idea->stage}"), 'iconColor' => 'text-gray-500 dark:text-gray-400'],
                    ] as $card)
                        <x-small-detailed-card :icon="$card['icon']" :label="$card['label']" :value="$card['value']" :iconColor="$card['iconColor']" />
                    @endforeach
                </div>

                <!-- Feasibility Study -->
                @if ($idea->feasibility_study)
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">دراسة الجدوى</h2>
                        <a href="{{ filter_var($idea->feasibility_study, FILTER_VALIDATE_URL) ? $idea->feasibility_study : asset('storage/' . $idea->feasibility_study) }}"
                           target="_blank"
                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                            <i data-lucide="file-text" class="w-5 h-5 inline-block"></i>
                            تحميل دراسة الجدوى
                        </a>
                    </div>
                @endif

                <!-- Categories Section -->
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">التصنيفات</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($idea->categories as $category)
                            <span class="px-3 py-1 bg-purple-900 text-purple-200 rounded-full text-sm">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <!-- Idea Stages Timeline -->
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">مراحل الفكرة</h2>
                    <div class="relative">
                        <div class="absolute h-full w-0.5 bg-gray-200 dark:bg-gray-700 right-1.5"></div>
                        <div class="space-y-6">
                            @foreach ($idea->stages as $stage)
                                <div class="relative flex items-center">
                                    <div class="absolute right-0 h-3 w-3 rounded-full {{ $stage->stage_status ? 'bg-green-500 dark:bg-green-400' : 'bg-gray-300 dark:bg-gray-600' }}"></div>
                                    <div class="mr-6">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ __("ideas.stages.{$stage->stage}") }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $stage->changed_at ? $stage->changed_at->format('Y/m/d H:i') : 'لم يتم التحديث بعد' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-3">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        الموافقة على الفكرة
                    </button>
                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        رفض الفكرة
                    </button>
                </div>
            </div>
        </x-card-gradient-bg>
    </div>
</x-layout>
