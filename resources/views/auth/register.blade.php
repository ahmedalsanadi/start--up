<x-guest-layout title="Register">
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4 mt-20">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
            class="form-container grid grid-cols-1 md:grid-cols-2 gap-2">
            @csrf
            <h2 class="form-title col-span-1 md:col-span-2">إنشاء حساب جديد</h2>

            <!-- Name Input Field -->
            <div class="form-group">
                <label for="name" class="form-label">الاسم الكامل</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input"
                    placeholder="John Doe" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Input Field -->
            <div class="form-group">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input"
                    placeholder="example@example.com" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input Field -->
            <div class="form-group">
                <label for="password" class="form-label">كلمة المرور</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Input Field -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                    placeholder="••••••••" required>
                @error('password_confirmation')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number Input Field -->
            <div class="form-group">
                <label for="phone_number" class="form-label">رقم الهاتف</label>
                <input type="text" id="phone_number" value="{{ old('phone_number') }}" name="phone_number"
                    class="form-input" placeholder="+1234567890" required>
                @error('phone_number')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- City Input Field -->
            <div class="form-group">
                <label for="city" class="form-label">المدينة</label>
                <input type="text" id="city" name="city" value="{{ old('city') }}" class="form-input"
                    placeholder="اسم المدينة" required>
                @error('city')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address Input Field -->
            <div class="form-group">
                <label for="address" class="form-label">العنوان</label>
                <input id="address" name="address" value="{{ old('address') }}" class="form-input" placeholder="عنوانك"
                    required>
                @error('address')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- User Type Select Field -->
            <div class="form-group">
                <label for="user_type" class="form-label">التسجيل كـ</label>
                <select id="user_type" name="user_type" class="form-input" required>
                    <option value="2" {{ old('user_type') == '2' ? 'selected' : '' }}>مستثمر</option>
                    <option value="3" {{ old('user_type') == '3' ? 'selected' : '' }}>رائد أعمال</option>
                </select>
                @error('user_type')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Profile Image Upload Field -->
            <div class="form-group col-span-1 md:col-span-2"">
                <label for=" profile_image" class="form-label">صورة الملف الشخصي (اختياري)</label>
                <input type="file" id="profile_image" name="profile_image" class="form-input-file">
                @error('profile_image')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Privacy Policy Acceptance Checkbox -->
            <!-- Modal Trigger -->
            <div class="form-group col-span-1 md:col-span-2">
                <label for="privacy_policy" class="form-label">
                    <input type="checkbox" id="privacy_policy" name="privacy_policy" required>
                    <a href="#" id="policyLink" class="text-blue-600 hover:underline dark:text-blue-500">سياسة الخصوصية</a>

                </label>
                @error('privacy_policy')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>


            <!-- Submit Button -->
            <div class="col-span-1 md:col-span-2">
                <button type="submit" class="btn-primary w-full">تسجيل</button>
            </div>

            <div class="mt-4 text-center col-span-1 md:col-span-2">
                <p class="text-sm text-gray-600 dark:text-gray-400">هل لديك حساب بالفعل؟
                    <a href="/login" class="text-blue-600 hover:underline dark:text-blue-500">تسجيل الدخول</a>
                </p>
            </div>
        </form>

    </div>
    <div id="privacyModal" class="modal hidden fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="modal-content bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-4xl mx-auto relative">
        <div class="modal-header border-b border-gray-200 dark:border-gray-700 p-4">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">سياسة الخصوصية</h2>
            <button id="closeModal" class="absolute top-4 left-4 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body p-6 overflow-y-auto max-h-[70vh] text-right">
            <div class="space-y-6 text-gray-800 dark:text-gray-200">
                <div class="policy-section">
                    <p class="mb-4">نحن ملتزمون في[START UP BOX] بحماية خصوصيتك وأمان معلوماتك. هذه السياسة توضح كيفية جمعنا واستخدامنا وكشفنا عن المعلومات التي نجمعها عنك عند استخدامك لموقعنا وخدماتنا.</p>
                </div>

                <div class="policy-section">
                    <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">جمع المعلومات:</h3>
                    <p class="mb-2">نحن نجمع أنواعًا مختلفة من المعلومات عنك، بما في ذلك:</p>
                    <ul class="list-disc list-inside space-y-2 pr-4">
                        <li>معلومات شخصية: مثل اسمك، وعنوان بريدك الإلكتروني، وكلمة المرور، ومعلومات الاتصال الأخرى التي تقدمها لنا طواعية.</li>
                        <li>معلومات حول الاستخدام: مثل الصفحات التي تزورها، والروابط التي تنقر عليها، والوقت الذي تقضيه في استخدام موقعنا.</li>
                    </ul>
                </div>

                <div class="policy-section">
                    <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">حماية الأفكار:</h3>
                    <div class="space-y-2">
                        <p>نحن ندرك أهمية حماية الأفكار المقدمة من رواد الأعمال للمستثمرين على موقعنا. لذلك، نؤكد على ما يلي:</p>
                        <ul class="list-disc list-inside space-y-2 pr-4">
                            <li>عدم امتلاك الموقع لأي حق ملكية فكرية: أي فكرة أو ابتكار يتم تقديمه عبر موقعنا يبقى ملكًا حصريًا لصاحبه.</li>
                            <li>سرية المعلومات: نتعهد بمعاملة جميع المعلومات المقدمة بشكل سرّي.</li>
                            <li>اتفاقيات عدم الإفشاء: نشجع جميع الأطراف على توقيع اتفاقيات عدم الإفشاء لحماية الأفكار بشكل أكبر.</li>
                        </ul>
                    </div>
                </div>

                <div class="policy-section">
                    <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">إخلاء المسؤولية:</h3>
                    <p>على الرغم من جهودنا لحماية الأفكار المقدمة، فإننا لا نتحمل مسؤولية أي انتهاك لحقوق الملكية الفكرية قد يحدث. ننصح رواد الأعمال بتسجيل براءات الاختراع أو حقوق النشر الخاصة بأفكارهم قبل مشاركتها على أي منصة.</p>
                </div>

                <div class="policy-section">
                    <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-white">تعديل سياسة الخصوصية:</h3>
                    <p>نحتفظ بالحق في تعديل هذه السياسة في أي وقت. ننصحك بمراجعة هذه السياسة بشكل دوري للاطلاع على أي تغييرات.</p>
                </div>
            </div>
        </div>
        <div class="modal-footer border-t border-gray-200 dark:border-gray-700 p-4 flex justify-end">
            <button id="acceptPolicy" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200">
                موافق
            </button>
        </div>
    </div>
</div>

<style>
.modal {
    direction: rtl;
}

.modal-content {
    animation: modalFade 0.3s ease-out;
}

@keyframes modalFade {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('privacyModal');
    const closeBtn = document.getElementById('closeModal');
    const acceptBtn = document.getElementById('acceptPolicy');
    const policyLink = document.getElementById('policyLink');
    const policyCheckbox = document.getElementById('privacy_policy');

    // Show modal when clicking on the privacy policy link
    policyLink.addEventListener('click', function(e) {
        e.preventDefault();
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    // Close modal functions
    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking the close button
    closeBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Accept policy
    acceptBtn.addEventListener('click', function() {
        policyCheckbox.checked = true;
        closeModal();
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
});

</script>

</x-guest-layout>
