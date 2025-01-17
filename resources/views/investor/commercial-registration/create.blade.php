<x-layout title="السجل التجاري">
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4">
        <div class="w-full max-w-2xl">
            <form method="POST" action="{{ route('commercial-registration.store') }}" class="form-container">
                @csrf
                <div class="space-y-6">
                    <div class="text-center">
                        <h2 class="form-title">تفاصيل السجل التجاري</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">يرجى تقديم معلومات السجل التجاري الخاص بك للمتابعة</p>
                    </div>

                    <!-- رقم السجل التجاري -->
                    <div class="form-group">
                        <label for="registration_number" class="form-label">رقم السجل التجاري</label>
                        <input
                            type="text"
                            id="registration_number"
                            name="registration_number"
                            value="{{ old('registration_number') }}"
                            class="form-input"
                            placeholder="أدخل رقم السجل التجاري الخاص بك"
                            required
                        >
                        @error('registration_number')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- تأكيد رقم السجل التجاري -->
                    <div class="form-group">
                        <label for="registration_number_confirmation" class="form-label">تأكيد رقم السجل التجاري</label>
                        <input
                            type="text"
                            id="registration_number_confirmation"
                            name="registration_number_confirmation"
                            class="form-input"
                            placeholder="أكد رقم السجل التجاري الخاص بك"
                            required
                        >
                        @error('registration_number_confirmation')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- زر التقديم -->
                    <div>
                        <button type="submit" class="btn-primary w-full">
                            تقديم الطلب
                        </button>
                    </div>

                    <!-- ملاحظة إعلامية -->
                    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    سيتم مراجعة طلبك من قبل فريق الإدارة. سيتم إعلامك بمجرد الموافقة على طلبك.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>
