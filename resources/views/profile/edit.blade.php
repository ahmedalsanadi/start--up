<x-layout title="تعديل الملف الشخصي">
    <div class="flex items-center justify-center pt-4 pb-1">
        <div class="max-w-4xl w-full space-y-8 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xl p-4 md:p-8">
            <!-- Form Header -->
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-indigo-950 dark:text-white">
                    تعديل الملف الشخصي
                </h2>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                    قم بتحديث بياناتك الشخصية هنا
                </p>
            </div>

            <!-- Form Start -->
            <form action="{{ route('profile.update', ['profile' => $user->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Grid for inputs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Name -->
                    <div>
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-input">
                        @error('name')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-input">
                        @error('email')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone_number" class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="form-input">
                        @error('phone_number')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="form-label">المدينة</label>
                        <input type="text" name="city" id="city" value="{{ old('city', $user->city) }}" class="form-input">
                        @error('city')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Password (Optional) -->
                    <div>
                        <label for="password" class="form-label">كلمة المرور الجديدة (اختياري)</label>
                        <input type="password" name="password" id="password" class="form-input">
                        @error('password')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                    </div>

                </div>

                   <!-- Profile Image -->
                   <div>
                        <label for="profile_image" class="form-label">تغيير الصورة الشخصية</label>
                        <input type="file" name="profile_image" id="profile_image" class="form-input-file">
                        @error('profile_image')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                <!-- Submit Button -->
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">حفظ التغييرات</button>
            </form>
        </div>
    </div>
</x-layout>
