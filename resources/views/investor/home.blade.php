<x-layout title="Home">
<!-- resources/views/investor/home.blade.php -->
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">استكشف الأفكار التقليدية</h1>

        <!-- Search Bar -->
        <div class="w-full md:w-96">
            <form action="{{ route('investor.home') }}" method="GET" class="relative">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="w-full px-4 py-2 pr-10 text-sm border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                       placeholder="ابحث عن فكرة...">
                <i data-lucide="search" class="w-5 h-5 absolute left-3 top-2.5 text-gray-400"></i>
            </form>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-6">
        <div class="flex items-center gap-2 mb-4">
            <i data-lucide="filter" class="w-5 h-5 text-blue-500"></i>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">التصفية حسب القسم</h2>
        </div>

        <div class="flex flex-wrap gap-3">
            @foreach($categories->where('parent_id', null) as $parentCategory)
                <div class="relative group">
                    <button class="px-4 py-2 text-sm font-medium rounded-lg
                                 {{ in_array($parentCategory->id, request('categories', []))
                                    ? 'bg-blue-500 text-white'
                                    : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200' }}">
                        {{ $parentCategory->name }}
                        <i data-lucide="chevron-down" class="w-4 h-4 inline-block mr-1"></i>
                    </button>

                    <!-- Subcategories Dropdown -->
                    <div class="hidden group-hover:block absolute z-10 mt-2 w-48 rounded-md shadow-lg">
                        <div class="rounded-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5">
                            @foreach($parentCategory->children as $child)
                                <a href="{{ route('investor.home', ['category' => $child->id]) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Ideas Grid -->
    <div class="space-y-6">
        @forelse($ideas as $idea)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <x-profile-img :src="$idea->entrepreneur->profile_image" :alt="$idea->entrepreneur->name" size="md" />
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $idea->entrepreneur->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <i data-lucide="calendar" class="w-4 h-4 inline-block ml-1"></i>
                                    {{ $idea->created_at->format('Y/m/d') }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('investor.ideas.show', $idea) }}"
                           class="px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                            عرض التفاصيل
                            <i data-lucide="arrow-left" class="w-4 h-4 inline-block"></i>
                        </a>
                    </div>

                    <!-- Idea Details -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $idea->name }}</h2>
                        <p class="text-gray-600 dark:text-gray-300">{{ $idea->brief_description }}</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-small-detailed-card
                                icon="dollar-sign"
                                label="الميزانية المطلوبة"
                                :value="number_format($idea->budget, 0) . ' ريال'"
                                iconColor="text-green-500 dark:text-green-400"
                            />

                            <x-small-detailed-card
                                icon="map-pin"
                                label="الموقع"
                                :value="$idea->location"
                                iconColor="text-red-500 dark:text-red-400"
                            />
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap gap-2">
                            @foreach($idea->categories as $category)
                                <span class="px-3 py-1 text-sm font-medium rounded-full
                                           bg-blue-100 dark:bg-blue-900/30
                                           text-blue-600 dark:text-blue-300">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <i data-lucide="file-question" class="w-16 h-16 mx-auto text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">لا توجد أفكار متاحة</h3>
                <p class="text-gray-500 dark:text-gray-400">لم يتم العثور على أي أفكار تقليدية في الوقت الحالي</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-6">
            {{ $ideas->links() }}
        </div>
    </div>
</div>
</x-layout>
