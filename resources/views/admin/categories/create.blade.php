@php
    use App\Models\Category;
@endphp
<x-layout title="Create Category">
    <div class=" flex items-center justify-center pt-4 pb-1 ">
        <div
            class="max-w-4xl w-full space-y-8 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl p-4 md:p-8">
            <!-- Form Header -->
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-indigo-950 dark:text-white">
                    إنشاء قسم جديد
                </h2>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                    قم بإدخال المعلومات المطلوبة لإنشاء قسم جديد
                </p>
            </div>

            <x-forms.form method="POST" action="{{ route('admin.categories.store') }}" class="mt-8 space-y-6">
                <!-- Category Name Field -->
                <div>
                    <label for="name" class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
                        اسم القسم
                    </label>
                    <div class="mt-1">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class=" form-input "
                            placeholder="أدخل اسم القسم">
                    </div>
                    @error('name')
                        <p class=" form-error">{{ $message }} </p>
                    @enderror

                </div>
                <!-- Parent Category Field -->
                <div class="mt-6">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        القسم الرئيسي
                    </label>
                    <div class="mt-1">
                        @if(isset($parent_id))
                            <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                            <select name="parent_id" id="parent_id" class="form-input" disabled>
                                <option value="{{ $parent_id }}" selected>
                                    {{ Category::find($parent_id)->name }}
                                </option>
                            </select>
                        @else
                            <select name="parent_id" id="parent_id" class="form-input">
                                <option value="">-- اختر القسم الرئيسي --</option>
                                <option value="">لا يوجد</option>
                                @foreach ($parentCategories as $parent)
                                    <option value="{{ $parent->id }}">
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    @error('parent_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-8">
                    <button type="submit" class="btn-primary w-full">
                        إنشاء القسم
                    </button>
                </div>

                <!-- ملاحظة إعلامية -->
                <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="mr-3">
                            @if (isset($parent_id))
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    أنت تقوم بإنشاء قسم فرعي تحت القسم الرئيسي
                                    "<strong>{{ Category::find($parent_id)->name }}</strong>".
                                </p>
                            @else
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    دع القسم الرئيسي فارغاً ليكون هذا القسم رئيسياً.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </x-forms.form>
        </div>
    </div>
</x-layout>
