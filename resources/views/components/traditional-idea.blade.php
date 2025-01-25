@props(['idea'])

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
                <x-badge :type="$idea->approval_status" :label="__('ideas.status.' . $idea->status)" />
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

            <!-- Idea Image and Key Details Grid -->
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Idea Image -->
                <div class="lg:w-1/2 h-64 rounded-xl overflow-hidden relative group">
                    <img src="{{ $idea->image ? (filter_var($idea->image, FILTER_VALIDATE_URL) ? $idea->image : asset('storage/' . $idea->image)) : 'https://placehold.co/800x400/e2e8f0/1e293b?text=No+Image+Available' }}"
                        alt="صورة الفكرة"
                        class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-105">
                    <div
                        class="absolute inset-0 bg-black/20 dark:bg-black/40 transition-opacity duration-300 group-hover:opacity-0">
                    </div>
                </div>

                <!-- Key Details Grid -->
                <x-key-details-grid :idea="$idea" />
                
            </div>



            <!-- Feasibility Study -->
            <x-feasibility-study :feasibilityStudy="$idea->feasibility_study" />

            <!-- Categories Section -->
            <x-categories-section :categories="$idea->categories" />
        </div>
    </div>
</x-card-gradient-bg>
