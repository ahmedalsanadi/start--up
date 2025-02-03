<x-layout title="Home">
    <div class="space-y-8">
        <!-- Hero Section -->
        <div
            class="relative bg-gradient-to-r from-purple-600 to-indigo-600 dark:from-purple-700 dark:to-indigo-800 rounded-2xl p-8 mb-8 overflow-hidden">
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0">
                <!-- Gradient Circles -->
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-purple-400/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-indigo-400/20 rounded-full blur-3xl"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <!-- Text Content -->
                <div class="text-white text-center md:text-right">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in-up">
                        استكشف الأفكار التقليدية
                    </h1>
                    <p class="text-lg text-purple-100 animate-fade-in-up delay-100">
                        اكتشف فرص استثمارية واعدة من رواد الأعمال المبدعين
                    </p>
                </div>

                <!-- Enhanced Search Bar -->
                <div class="w-full md:w-96 animate-fade-in-up delay-200">
                    <form action="{{ route('investor.home') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full px-6 py-3 pr-12 text-base rounded-xl border-2 border-purple-400 bg-white/10 backdrop-blur-md text-white placeholder-purple-200 focus:ring-2 focus:ring-white focus:border-transparent transition-all duration-300"
                            placeholder="ابحث عن فكرة...">
                        <button type="submit"
                            class="absolute left-3 top-1/2 -translate-y-1/2 p-2 text-purple-200 hover:text-white transition-colors duration-300">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Animated Icons -->
            <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-purple-400/20 rounded-full blur-2xl animate-float">
            </div>
            <div
                class="absolute -top-10 -right-10 w-24 h-24 bg-indigo-400/20 rounded-full blur-2xl animate-float delay-1000">
            </div>
        </div>
        <!-- Filters Section -->
        <div class="bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                        <i data-lucide="filter" class="w-5 h-5 text-blue-600 dark:text-blue-400"></i>
                    </span>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">تصفية النتائج</h2>
                </div>

                <!-- Selected Categories Pills -->
                <div id="selectedCategoriesPills" class="flex flex-wrap gap-2"></div>

                <!-- Clear Filters Button -->
                <button id="clearFilters" class="text-sm text-red-500 hover:text-red-700 hidden">
                    مسح التصفية
                    <i data-lucide="x" class="w-4 h-4 inline-block"></i>
                </button>
            </div>

            <form id="filterForm" action="{{ route('investor.home') }}" method="GET">
                <input type="hidden" name="categories" id="selectedCategories" value="{{ request('categories') }}">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div class="flex flex-wrap gap-3">
                    @foreach($categories as $parentCategory)
                        <div class="category-group relative">
                            <button type="button"
                                class="category-parent px-5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                                                           bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                {{ $parentCategory->name }}
                                <i data-lucide="chevron-down" class="w-4 h-4 inline-block mr-1"></i>
                            </button>

                            <div
                                class="category-children hidden absolute z-20 mt-2 w-56 rounded-xl shadow-xl bg-white dark:bg-gray-700 p-2">
                                @foreach($parentCategory->children as $child)
                                    <label
                                        class="flex items-center px-4 py-3 rounded-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input type="checkbox" value="{{ $child->id }}" data-category-name="{{ $child->name }}"
                                            class="category-checkbox form-checkbox h-4 w-4 text-blue-600 rounded border-gray-300"
                                            {{ in_array($child->id, $selectedCategories) ? 'checked' : '' }}>
                                        <span class="mr-3 text-sm text-gray-700 dark:text-gray-200">{{ $child->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
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

                                        <x-profile-img src="{{ $idea->entrepreneur->profile_image }}" alt="User Avatar"
                                            size="md" />
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

    @push('scripts')
        <script>

            document.addEventListener('DOMContentLoaded', function () {
                const filterForm = document.getElementById('filterForm');
                const selectedCategoriesInput = document.getElementById('selectedCategories');
                const clearFiltersBtn = document.getElementById('clearFilters');
                const categoryGroups = document.querySelectorAll('.category-group');
                const selectedCategoriesPills = document.getElementById('selectedCategoriesPills');

                // Initialize selectedCategories Map
                let selectedCategories = new Map();

                // Initialize the map with existing selections
                if (selectedCategoriesInput.value) {
                    const categoryIds = selectedCategoriesInput.value.split(',');
                    categoryIds.forEach(id => {
                        const checkbox = document.querySelector(`input[value="${id}"]`);
                        if (checkbox) {
                            selectedCategories.set(id, checkbox.dataset.categoryName);
                            checkbox.checked = true;
                        }
                    });
                }

                function updateSelectedCategoriesPills() {
                    selectedCategoriesPills.innerHTML = '';
                    selectedCategories.forEach((name, id) => {
                        if (name) { // Only create pill if name exists
                            const pill = document.createElement('div');
                            pill.className = 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full px-3 py-1 text-sm flex items-center gap-2';
                            pill.innerHTML = `
                                        ${name}
                                        <button type="button" data-category-id="${id}" class="remove-category">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </button>
                                    `;
                            selectedCategoriesPills.appendChild(pill);
                        }
                    });

                    // Re-initialize Lucide icons
                    if (window.lucide) {
                        window.lucide.createIcons();
                    }
                }

                function updateForm() {
                    selectedCategoriesInput.value = Array.from(selectedCategories.keys()).join(',');
                    clearFiltersBtn.classList.toggle('hidden', selectedCategories.size === 0);
                    updateSelectedCategoriesPills();
                }

                // Initial state
                updateForm();

                // Handle category parent button clicks
                categoryGroups.forEach(group => {
                    const parentBtn = group.querySelector('.category-parent');
                    const childrenDiv = group.querySelector('.category-children');

                    parentBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        categoryGroups.forEach(otherGroup => {
                            if (otherGroup !== group) {
                                otherGroup.querySelector('.category-children').classList.add('hidden');
                            }
                        });
                        childrenDiv.classList.toggle('hidden');
                    });

                    // Handle checkbox changes
                    const checkboxes = group.querySelectorAll('.category-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', () => {
                            if (checkbox.checked) {
                                selectedCategories.set(checkbox.value, checkbox.dataset.categoryName);
                            } else {
                                selectedCategories.delete(checkbox.value);
                            }
                            updateForm();
                            filterForm.submit();
                        });
                    });
                });

                // Close dropdowns when clicking outside
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.category-group')) {
                        categoryGroups.forEach(group => {
                            group.querySelector('.category-children').classList.add('hidden');
                        });
                    }
                });

                // Handle removing categories via pills
                selectedCategoriesPills.addEventListener('click', (e) => {
                    const removeBtn = e.target.closest('.remove-category');
                    if (removeBtn) {
                        const categoryId = removeBtn.dataset.categoryId;
                        selectedCategories.delete(categoryId);
                        const checkbox = document.querySelector(`input[value="${categoryId}"]`);
                        if (checkbox) {
                            checkbox.checked = false;
                        }
                        updateForm();
                        filterForm.submit();
                    }
                });

                // Clear filters
                clearFiltersBtn.addEventListener('click', () => {
                    selectedCategories.clear();
                    document.querySelectorAll('.category-checkbox').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    updateForm();
                    filterForm.submit();
                });
            });


        </script>
    @endpush
</x-layout>