<x-layout title="إنشاء فكرة جديدة">
    @php
        $ideaType = isset($announcement_id) ? 'creative' : 'traditional';
        $formTitle = isset($announcement_id) ? 'فكرة مبتكرة' : 'فكرة تقليدية';
        $announcementDescription = isset($announcement_id) ? $announcement->description : null;
    @endphp

    <div class="flex items-center justify-center pt-4 pb-1">
        <div
            class="max-w-4xl w-full space-y-8 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl p-4 md:p-8">
            <!-- Form Header -->
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-indigo-950 dark:text-white">
                    انشاء {{ $formTitle }}
                </h2>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                    قم بملء البيانات التالية لإنشاء ({{ $formTitle }}) جديدة
                </p>

                <!-- Notice for Creative Ideas -->
                @if ($ideaType === 'creative')
                    <div
                        class="mt-4 p-4 bg-purple-50 dark:bg-purple-900 rounded-lg border border-purple-200 dark:border-purple-700">
                        <p class="text-purple-800 dark:text-purple-200">
                            <span class="font-semibold">ملاحظة:</span> هذه الفكرة مرتبطة بالإعلان التالي:
                            <span class="font-semibold">{{ $announcementDescription }}</span>.
                            سيتم تطبيق مراحل التقييم والموافقة الخاصة بالأفكار المبتكرة.
                        </p>
                    </div>
                @else
                    <div
                        class="mt-4 p-4 bg-blue-50 dark:bg-blue-900 rounded-lg border border-blue-200 dark:border-blue-700">
                        <p class="text-blue-800 dark:text-blue-200">
                            <span class="font-semibold">ملاحظة:</span> هذه فكرة تقليدية ولا ترتبط بأي إعلان. سيتم تقييمها
                            بشكل مستقل.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Form -->
            <form id="addIdeaForm" method="POST" action="{{ route('entrepreneur.ideas.store') }}" class="mt-8 space-y-6"
                enctype="multipart/form-data">
                @csrf

                <!-- Hidden Announcement ID (if provided) -->
                @if (isset($announcement_id))
                    <input type="hidden" name="announcement_id" value="{{ $announcement_id }}">
                @endif

                <!-- Hidden Idea Type -->
                <!-- <input type="hidden" id="idea_type" name="idea_type" value="{{ $ideaType }}" /> -->
                <input type="hidden" id="idea_type" name="idea_type" value="{{ old('idea_type', $ideaType) }}" />


                @error('idea_type')
                    <p class="form-error">{{ $message }}</p>
                @enderror

                <!-- Idea Name -->
                <div>
                    <label for="name" class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
                        اسم الفكرة
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" required>
                    @error('name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Brief Description -->
                <div>
                    <label for="brief_description"
                        class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
                        وصف مختصر
                    </label>
                    <textarea id="brief_description" name="brief_description" rows="3" class="form-input"
                        placeholder="اكتب وصفاً مختصراً عن الفكرة..." required>{{ old('brief_description') }}</textarea>
                    @error('brief_description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Detailed Description -->
                <div>
                    <label for="detailed_description"
                        class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
                        وصف تفصيلي
                    </label>
                    <textarea id="detailed_description" name="detailed_description" rows="6" class="form-input"
                        placeholder="اكتب وصفاً تفصيلياً عن الفكرة..." required>{{ old('detailed_description') }}</textarea>
                    @error('detailed_description')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Categories Section -->
                <div class="mt-6">
                    <label for="categories" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        التصنيفات
                    </label>

                    <div x-data="{
    search: '',
    selectedCategories: {{ $oldCategories->toJson() }}, // Initialize with old category objects
    showDropdown: false,
    categories: {{ $categories->toJson() }},

    get filteredCategories() {
        if (this.selectedCategories.length >= 5) {
            return []; // Hide all categories when the limit is reached
        }

        if (this.search === '') {
            // Show categories not selected, limit to 5
            return this.categories
                .filter(cat => !this.selectedCategories.find(sc => sc.id === cat.id))
                .slice(0, 5);
        } else {
            // Filter categories based on search input
            const filtered = this.categories.filter(cat =>
                cat.name.toLowerCase().includes(this.search.toLowerCase()) &&
                !this.selectedCategories.find(sc => sc.id === cat.id)
            );
            return filtered.length > 0 ? filtered : null; // Return null if no matches
        }
    },

    addCategory(category) {
        if (this.selectedCategories.length < 5) {
            this.selectedCategories.push(category);
            this.showDropdown = false;
            this.search = '';
        }
    },

    removeCategory(category) {
        this.selectedCategories = this.selectedCategories.filter(c => c.id !== category.id);
    }
}">
    <!-- Search Input -->
    <div class="relative mb-4">
        <input type="text" x-model="search" @focus="showDropdown = true"
            @click.away="showDropdown = false" class="form-input"
            placeholder="ابحث عن التصنيفات...">

        <!-- Dropdown -->
        <div x-show="showDropdown" x-cloak
            class="absolute z-50 mt-1 w-full bg-gray-100 dark:bg-gray-800 rounded-md shadow-lg max-h-60 overflow-y-auto">

            <!-- Message when 5 categories are selected -->
            <template x-if="selectedCategories.length >= 5">
                <div class="px-4 py-2 text-gray-800 dark:text-gray-200">
                    يمكنك اختيار 5 تصنيفات فقط.
                </div>
            </template>

            <!-- "Not Found" Message -->
            <template x-if="filteredCategories === null && selectedCategories.length < 5">
                <div class="px-4 py-2 text-gray-800 dark:text-gray-200">
                    لا توجد نتائج مطابقة.
                </div>
            </template>

            <!-- Dropdown Categories -->
            <template x-if="filteredCategories !== null && filteredCategories.length > 0">
                <ul class="py-1">
                    <template x-for="category in filteredCategories" :key="category.id">
                        <li>
                            <!-- Parent Category -->
                            <div @click="addCategory(category)"
                                class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200"
                                x-text="category.name"></div>

                            <!-- Child Categories -->
                            <template x-if="category.children && category.children.length > 0">
                                <ul class="pl-4">
                                    <template x-for="child in category.children" :key="child.id">
                                        <li @click="addCategory(child)"
                                            class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200"
                                            x-text="child.name"></li>
                                    </template>
                                </ul>
                            </template>
                        </li>
                    </template>
                </ul>
            </template>
        </div>
    </div>

    <!-- Selected Categories -->
    <div class="flex flex-wrap gap-2">
        <template x-for="category in selectedCategories" :key="category.id">
            <div
                class="inline-flex items-center bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full px-3 py-1">
                <span x-text="category.name"></span>
                <button type="button" @click="removeCategory(category)"
                    class="mr-2 text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <input type="hidden" name="categories[]" :value="category.id">
            </div>
        </template>
    </div>
    @error('categories')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
                </div>


                <!-- Grid Container -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Location  -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            الموقع
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}"
                            class="form-input" placeholder="المدينة، الدولة">
                        @error('location')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Budget  -->
                    <div>
                        <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            الميزانية (بالريال)
                        </label>
                        <input type="number" id="budget" name="budget" value="{{ old('budget') }}" class="form-input"
                            placeholder="أدخل الميزانية المتاحة" min="0">
                        @error('budget')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Feasibility Study (PDF) -->
                    <div>
                        <label for="feasibility_study"
                            class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
                            دراسة الجدوى (PDF , doc, docx)
                        </label>
                        <input type="file" id="feasibility_study" name="feasibility_study" class="form-input-file "
                            accept="application/pdf">
                        @error('feasibility_study')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="image" class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
                            صورة الفكرة
                        </label>
                        <input type="file" id="image" name="image" class="form-input-file" accept="image/*">
                        @error('image')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="btn-primary w-full">
                        إنشاء الفكرة
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
