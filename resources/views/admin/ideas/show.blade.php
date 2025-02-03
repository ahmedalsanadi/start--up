<x-layout title="تفاصيل الفكرة">
    <div class="space-y-6">
        <!-- Idea Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">بيانات الفكرة</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    تم النشر في {{ $idea->created_at->format('Y/m/d') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Right Side: Idea Stages Timeline -->
            <div class="lg:col-span-2">
                <x-card-gradient-bg>
                    <!-- Decorative Background Element -->
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-blue-50 dark:bg-blue-900/20 rounded-full -translate-y-32 translate-x-32 blur-3xl">
                    </div>

                    <!-- Idea Details Card -->
                    <div class="relative space-y-8">
                        <!-- Header Section: Entrepreneur Profile and Status -->
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <!-- Entrepreneur Info -->
                            <div class="flex items-center gap-4">
                                <x-profile-img src="{{ $idea->entrepreneur->profile_image }}" alt="صورة رائد الأعمال" />
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $idea->entrepreneur->name }}
                                    </h3>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        رائد أعمال
                                    </span>
                                </div>
                            </div>

                            <!-- Status and Time -->
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="clock" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $idea->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <!-- Status Badge -->
                                @if($idea->status == 'in-progress')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium
                                                                                                 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400
                                                                                                 border border-amber-200 dark:border-amber-800">
                                        جاري
                                    </span>
                                @endif

                                @if($idea->status == 'approved')
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium
                                                                                                 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400
                                                                                                 border border-green-200 dark:border-green-800">
                                        تمت الموافقة
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Main Content Section -->
                        <div class="space-y-6">
                            <!-- Title and Description -->
                            <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-6">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $idea->name }}</h3>
                                <p class="text-gray-700 dark:text-gray-300 text-base leading-relaxed mb-4">
                                    {{ $idea->brief_description }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                    {{ $idea->detailed_description }}
                                </p>
                            </div>

                            <!-- Idea Image -->
                            <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden">
                                <img src="{{ $idea->image
    ? (filter_var($idea->image, FILTER_VALIDATE_URL)
        ? $idea->image
        : asset('storage/' . $idea->image))
    : 'https://placehold.co/800x400/e2e8f0/1e293b?text=No+Image+Available' }}" alt="صورة الفكرة"
                                    class="w-full h-full object-cover" loading="lazy">
                            </div>

                            <!-- Key Details Grid -->
                            <x-key-details-grid :idea="$idea" />

                            <x-feasibility-study :feasibilityStudy="$idea->feasibility_study"
                                title="دراسة الجدوى المالية" fileName="الجدوى_المالية.pdf" />

                            <!-- Categories Section -->
                            <x-categories-section :categories="$idea->categories" />


                        </div>
                    </div>
                </x-card-gradient-bg>
            </div>

            <!-- Left Side: Idea Details -->
            <div class="space-y-6">


                <!-- Admin Actions -->
                <div
                    class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">إجراءات الإدارة</h3>
                        @if($idea->approval_status === 'pending')
                            <div class="space-y-4">
                                <form action="{{ route('admin.ideas.update-status', $idea) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="approval_status" value="approved">
                                    <button type="submit"
                                        class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                        الموافقة على الفكرة
                                    </button>
                                </form>
                                <button onclick="openRejectModal()"
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                    رفض الإعلان
                                </button>
                            </div>
                        @elseif($idea->approval_status === 'rejected')
                            <div class="bg-red-50 dark:bg-red-900/30 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-red-800 dark:text-red-300 mb-2">سبب الرفض:</h4>
                                <p class="text-red-700 dark:text-red-200">{{ $idea->rejection_reason }}</p>
                            </div>
                        @elseif($idea->approval_status === 'approved')
                            <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-8">
                                <h4 class="text-md font-medium text-green-800 dark:text-green-300 mb-2">حالة الفكرة:</h4>
                                <p class="text-green-700 dark:text-green-200">تمت الموافقة على هذا الفكرة .</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($idea->announcement)
                    <x-card-gradient-bg :withGradient="false">
                        <!-- Section Title -->
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-right">
                            تفاصيل الإعلان المرتبط
                        </h2>

                        <!-- Announcement Details -->
                        <div class="space-y-6">
                            <!-- Announcement Title -->
                            <a href="{{ route('admin.announcements.show', $idea->announcement) }}"
                                class="group block p-4 rounded-lg bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <!-- Icon -->
                                    <div
                                        class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex-shrink-0 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors duration-300">
                                        <i data-lucide="megaphone" class="w-6 h-6 text-blue-500 dark:text-blue-400"></i>
                                    </div>

                                    <!-- Details -->
                                    <div class="flex flex-col gap-1">
                                        <p
                                            class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                            الإعلان: {{ $idea->announcement->description }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            تاريخ الإعلان: {{ $idea->announcement->created_at->format('Y/m/d') }}
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <!-- Investor Information -->
                            <a href="#"
                                class="group block p-4 rounded-lg bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400 transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <!-- Profile Image -->

                                    <x-profile-img src="{{ $idea->announcement->investor->profile_image }}"
                                        alt="User Avatar" size="md" />

                                    <!-- Details -->
                                    <div class="flex flex-col gap-1">
                                        <p
                                            class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300">
                                            المستثمر: {{ $idea->announcement->investor->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            البريد الإلكتروني: {{ $idea->announcement->investor->email }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            رقم الهاتف: {{ $idea->announcement->investor->phone_number }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </x-card-gradient-bg>

                @endif



                <x-card-gradient-bg :withGradient="false">
                    <div class="max-w-2xl mx-auto">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-right">مراحل تقييم الفكرة
                        </h2>

                        <div class="relative">
                            <!-- Vertical Line -->
                            <div class="absolute h-full w-0.5 bg-gray-200 dark:bg-gray-700 right-4"></div>

                            <div class="space-y-12">
                                @php
                                    $allStages = ['new', 'initial_acceptance', 'under_review', 'expert_consultation', 'final_decision'];
                                    $currentStageIndex = array_search($idea->stage, $allStages);
                                @endphp

                                @foreach($allStages as $index => $stageName)
                                                                @php
                                                                    $stage = $idea->stages->where('stage', $stageName)->first();
                                                                    $isCompleted = $stage && $stage->stage_status;
                                                                    $isCurrent = $idea->stage === $stageName;
                                                                    $isPending = $index > $currentStageIndex;
                                                                @endphp

                                                                <div class="relative flex items-start group">
                                                                    <!-- Stage Indicator -->
                                                                    <div
                                                                        class="absolute right-0 flex items-center justify-center h-8 w-8 rounded-full border-2
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    {{ $isCompleted ? 'bg-lime-500 border-lime-500' : ($isCurrent ? 'bg-blue-500 border-blue-500' : 'bg-gray-100 border-gray-300') }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    dark:border-opacity-50 z-10">
                                                                        @if($isCompleted)
                                                                            <i data-lucide="check" class="w-4 h-4 text-white"></i>
                                                                        @elseif($isCurrent)
                                                                            <i data-lucide="loader" class="w-4 h-4 text-white animate-spin"></i>
                                                                        @else
                                                                            <i data-lucide="circle" class="w-4 h-4 text-gray-400"></i>
                                                                        @endif
                                                                    </div>

                                                                    <!-- Stage Content -->
                                                                    <div class="mr-12 flex-1">
                                                                        <div
                                                                            class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        {{ $isCompleted ? 'border-l-4 border-green-500' : ($isCurrent ? 'border-l-4 border-blue-500' : '') }}">

                                                                            <div class="flex items-center justify-between mb-2">
                                                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                                    {{ __("ideas.stages.$stageName") }}
                                                                                </h3>
                                                                            </div>

                                                                            <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                                                                @if($stage)
                                                                                    <div class="flex items-center gap-2">
                                                                                        <i data-lucide="calendar" class="w-4 h-4"></i>
                                                                                        <span>{{ $stage->changed_at ? $stage->changed_at->format('Y/m/d H:i') : 'لم يتم التحديث بعد' }}</span>
                                                                                    </div>
                                                                                @else
                                                                                    <span class="text-gray-400">في انتظار الوصول لهذه المرحلة</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </x-card-gradient-bg>

            </div>

        </div>
    </div>
</x-layout>
