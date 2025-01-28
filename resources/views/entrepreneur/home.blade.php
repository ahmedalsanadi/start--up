<x-layout title="Home">
    <div class="space-y-8">
        <!-- Hero Section (Same as before) -->
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
                        استكشف الإعلانات
                    </h1>
                    <p class="text-lg text-purple-100 animate-fade-in-up delay-100">
                        اكتشف فرص استثمارية واعدة من المستثمرين المبدعين
                    </p>
                </div>

                <!-- Enhanced Search Bar -->
                <div class="w-full md:w-96 animate-fade-in-up delay-200">
                    <form action="{{ route('entrepreneur.home') }}" method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full px-6 py-3 pr-12 text-base rounded-xl border-2 border-purple-400 bg-white/10 backdrop-blur-md text-white placeholder-purple-200 focus:ring-2 focus:ring-white focus:border-transparent transition-all duration-300"
                            placeholder="ابحث عن إعلان...">
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

        <!-- Filters Section (Same as before) -->
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

            <form id="filterForm" action="{{ route('entrepreneur.home') }}" method="GET">
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

        <!-- Announcements Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($announcements as $announcement)
                <div
                    class="flex flex-col bg-gray-100 dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-300 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300 h-full">

                    <!-- Card Header -->
                    <div class="p-6 border-b border-gray-300 dark:border-gray-700">
                        <div class="flex items-center space-x-4 space-x-reverse">
                            <x-profile-img :src="$announcement->investor->profile_image"
                                :alt="$announcement->investor->name" size="md" />
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $announcement->investor->name }}
                                </h3>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <i data-lucide="calendar" class="w-4 h-4 ml-1"></i>
                                    {{ $announcement->created_at->format('Y/m/d') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-1 min-h-[160px]">
                        <p class="text-gray-600 dark:text-gray-300 line-clamp-3 mb-4 h-20">
                            {{ $announcement->description }}
                        </p>

                        <!-- Budget and Location -->
                        <div class="flex items-center gap-6 mt-4">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <i data-lucide="dollar-sign" class="w-6 h-6 text-green-500 dark:text-green-300"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">الميزانية</span>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ number_format($announcement->budget, 0) }} ريال
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <i data-lucide="map-pin" class="w-6 h-6 text-green-500 dark:text-green-300"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">الموقع</span>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ $announcement->location }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-6 ">
                        <!-- Categories -->
                        <div
                            class="flex flex-wrap gap-2 mb-4 min-h-[100px] border-b  border-gray-200 dark:border-gray-700 py-6 ">
                            @foreach($announcement->categories as $category)
                                <span
                                    class="px-4 py-1.5 text-xs font-medium rounded-full bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-900/50 text-blue-600 dark:text-blue-300">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('entrepreneur.announcements.show', $announcement) }}"
                                class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 flex items-center">
                                عرض التفاصيل
                                <i data-lucide="arrow-left" class="w-4 h-4 inline-block mr-2"></i>
                            </a>

                            <a href="{{ route('entrepreneur.ideas.create', ['announcement_id' => $announcement->id]) }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-300 flex items-center">
                                إضافة فكرة
                                <i data-lucide="plus" class="w-4 h-4 inline-block mr-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-white dark:bg-gray-800 rounded-2xl shadow-lg">
                    <div
                        class="w-20 h-20 mx-auto mb-6 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                        <i data-lucide="file-question" class="w-10 h-10 text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">لا توجد إعلانات متاحة</h3>
                    <p class="text-gray-500 dark:text-gray-400">لم يتم العثور على أي إعلانات في الوقت الحالي</p>
                </div>
            @endforelse
        </div>


        <!-- Pagination -->
        <div class="mt-8">
            {{ $announcements->links() }}
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
