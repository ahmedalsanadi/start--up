<x-layout title="إنشاء إعلان جديد">
    <div class="flex items-center justify-center pt-4 pb-1">
        <div
            class="max-w-4xl w-full space-y-8 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl p-4 md:p-8">
            <!-- Form Header -->
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-indigo-950 dark:text-white">
                    إنشاء إعلان جديد
                </h2>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                    قم بملء البيانات التالية لإنشاء إعلان جديد للمشاريع
                </p>
            </div>

            <x-forms.form method="POST" action="{{ route('investor.announcements.store') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Project Description -->
                <div>
                    <label for="description" class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
                        وصف المشروع
                    </label>
                    <textarea id="description" name="description" rows="6" class="form-input"
                        placeholder="اكتب وصفاً تفصيلياً عن المشروع الذي تبحث عنه...">{{ old('description') }}</textarea>
                    @error('description')
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
        selectedCategories: [],
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
                                        <template x-for="category in filteredCategories" :key="category . id">
                                            <li>
                                                <!-- Parent Category -->
                                                <div @click="addCategory(category)"
                                                    class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer text-gray-800 dark:text-gray-200"
                                                    x-text="category.name"></div>

                                                <!-- Child Categories -->
                                                <template x-if="category.children && category.children.length > 0">
                                                    <ul class="pl-4">
                                                        <template x-for="child in category.children" :key="child . id">
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
                            <template x-for="category in selectedCategories" :key="category . id">
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
                                    <input type="hidden" name="categories[]" :value="category . id">
                                </div>
                            </template>
                        </div>
                        @error('categories')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>




                </div>

                <!-- Additional Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                    <div>
                        <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            الميزانية (بالريال)
                        </label>
                        <input type="number" id="budget" name="budget" value="{{ old('budget') }}" class="form-input"
                            placeholder="أدخل الميزانية المتاحة">
                        @error('budget')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            تاريخ البدء
                        </label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}"
                            class="form-input" min="">
                        @error('start_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            تاريخ الانتهاء
                        </label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                            class="form-input" min="">
                        @error('end_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="btn-primary w-full">
                        نشر الإعلان
                    </button>
                </div>
            </x-forms.form>
        </div>
    </div>
    <script>

        // Set min attribute to today's date for both start_date and end_date inputs
        document.addEventListener('DOMContentLoaded', () => {
            const today = new Date().toISOString().split('T')[0]; // Format the date as YYYY-MM-DD
            document.getElementById('start_date').setAttribute('min', today);
            document.getElementById('end_date').setAttribute('min', today);
        });

    </script>
</x-layout>