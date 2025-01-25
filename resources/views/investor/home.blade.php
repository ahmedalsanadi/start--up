<x-layout title="Home">
    <div class="space-y-8">
        <!-- Hero Section -->
        <div
            class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-2xl p-8 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-white">
                    <h1 class="text-3xl font-bold mb-2">استكشف الأفكار التقليدية</h1>
                    <p class="text-blue-100">اكتشف فرص استثمارية واعدة من رواد الأعمال المبدعين</p>
                </div>

                <!-- Enhanced Search Bar -->
                <div class="w-full md:w-96">
                    <form action="{{ route('investor.home') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full px-6 py-3 pr-12 text-base rounded-xl border-2 border-blue-400 bg-white/10 backdrop-blur-md text-white placeholder-blue-200 focus:ring-2 focus:ring-white focus:border-transparent"
                            placeholder="ابحث عن فكرة...">
                        <button type="submit"
                            class="absolute left-3 top-1/2 -translate-y-1/2 p-2 text-blue-200 hover:text-white">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center gap-3 mb-6">
                <span class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                    <i data-lucide="filter" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                </span>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">تصفية النتائج</h2>
            </div>

            <div class="flex flex-wrap gap-3">
                @foreach($categories->where('parent_id', null) as $parentCategory)
                            <div class="relative group">
                                <button
                                    class="px-5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                                                                                                                                                         {{ in_array($parentCategory->id, request('categories', []))
                    ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30'
                    : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                    {{ $parentCategory->name }}
                                    <i data-lucide="chevron-down" class="w-4 h-4 inline-block mr-1"></i>
                                </button>

                                <!-- Enhanced Dropdown -->
                                <div class="hidden group-hover:block absolute z-10 mt-2 w-56 rounded-xl shadow-xl">
                                    <div class="bg-white dark:bg-gray-700 rounded-xl ring-1 ring-black ring-opacity-5 p-2">
                                        @foreach($parentCategory->children as $child)
                                            <a href="{{ route('investor.home', ['category' => $child->id]) }}"
                                                class="flex items-center px-4 py-3 rounded-lg text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                                <span class="w-2 h-2 rounded-full bg-blue-500 mr-3"></span>
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

                <div class="relative">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20">
                    </div>

                    <!-- Card Content -->
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900  rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 relative overflow-hidden"
                        dir="rtl">

                        <!-- Decorative Background Element -->
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-blue-50 dark:bg-blue-900/20 rounded-full -translate-y-32 translate-x-32 blur-3xl">
                        </div>

                        <!-- Card Content -->
                        <div class="flex flex-col md:flex-row">
                            <!-- Idea Image Section -->
                            <div class="md:w-1/3 relative overflow-hidden">
                                @if($idea->image)
                                                    <img src="{{
                                    filter_var($idea->image, FILTER_VALIDATE_URL) ? $idea->image : asset('storage/' . $idea->image) }}"
                                                        alt="{{ $idea->name }}" class="w-full h-full object-cover md:h-[400px]" />
                                @else
                                    <div
                                        class="w-full h-full min-h-[300px] bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <i data-lucide="image" class="w-12 h-12 text-gray-400"></i>
                                    </div>
                                @endif

                                <!-- Budget Badge -->
                                <div
                                    class="absolute top-4 right-4 px-4 py-2 bg-white/90 dark:bg-gray-800/90 rounded-lg backdrop-blur-sm shadow-lg">
                                    <p class="text-sm font-semibold text-green-600 dark:text-green-400">
                                        {{ number_format($idea->budget, 0) }} ريال
                                    </p>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="md:w-2/3 p-6 md:p-8">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center space-x-4 space-x-reverse">
                                        <x-profile-img :src="$idea->entrepreneur->profile_image"
                                            :alt="$idea->entrepreneur->name" size="md" />
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $idea->entrepreneur->name }}
                                            </h3>
                                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                <i data-lucide="calendar" class="w-4 h-4 ml-1"></i>
                                                {{ $idea->created_at->format('Y/m/d') }}
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('investor.ideas.show', $idea) }}"
                                        class="px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                        عرض التفاصيل
                                        <i data-lucide="arrow-left" class="w-4 h-4 inline-block"></i>
                                    </a>
                                </div>

                                <div class="space-y-8">
                                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $idea->name }}</h2>
                                    <p class="text-gray-600 dark:text-gray-300 line-clamp-3">{{ $idea->brief_description }}
                                    </p>

                                    <div class="flex items-center gap-6 mt-4">
                                        <div class="flex items-center gap-3">
                                            <!-- Icon Container -->
                                            <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                                <i data-lucide="map-pin"
                                                    class="w-8 h-8 text-green-500 dark:text-green-300"></i>
                                            </div>

                                            <!-- Label and Value -->
                                            <div class="flex flex-col justify-center gap-1">
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">الموقع
                                                </span>
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    {{$idea->location }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <!-- Icon Container -->
                                            <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                                <i data-lucide="dollar-sign"
                                                    class="w-8 h-8 text-green-500 dark:text-green-300"></i>
                                            </div>

                                            <!-- Label and Value -->
                                            <div class="flex flex-col justify-center gap-1">
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">الميزانية
                                                    </span>
                                                <p class="text-gray-600 dark:text-gray-400">
                                                    {{number_format($idea->budget, 0) . ' ريال'}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Categories -->
                                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($idea->categories as $category)
                                            <span
                                                class="px-4 py-1.5 text-sm font-medium rounded-full bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            @empty
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl shadow-lg">
                    <div
                        class="w-20 h-20 mx-auto mb-6 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        <i data-lucide="file-question" class="w-10 h-10 text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">لا توجد أفكار متاحة</h3>
                    <p class="text-gray-500 dark:text-gray-400">لم يتم العثور على أي أفكار تقليدية في الوقت الحالي</p>
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="mt-8">
                {{ $ideas->links() }}
            </div>
        </div>
    </div>
</x-layout>
