<x-layout title="Login">
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4">
        <form method="POST" action="{{ route('login') }}"
            class="w-full max-w-md p-6 bg-white rounded-lg shadow-md border border-gray-300 dark:bg-gray-800 dark:border-gray-700">
            @csrf
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">تسجيل الدخول إلى حسابك</h2>

            <!-- Email Input Field -->
            <div class="mb-5">
                <label for="email-address-icon"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">البريد الإلكتروني</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                            <path
                                d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                            <path
                                d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                        </svg>
                    </div>
                    <input type="text" id="email-address-icon" name="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="example@example.com" required>
                </div>
                <!-- Handle errors here -->
                @error('email')
                <p class="mt-2 px-1 text-sm text-red-600 dark:text-red-500"><span class="font-medium">خطأ!</span>
                    {{ $message }}
                </p>
                @enderror

            </div>

            <!-- Password Input Field -->
            <div class="mb-5">
                <label for="password-icon" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">كلمة المرور</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 0a5 5 0 0 0-5 5v3H3a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-2V5a5 5 0 0 0-5-5zm0 2a3 3 0 0 1 3 3v3H7V5a3 3 0 0 1 3-3z" />
                        </svg>
                    </div>
                    <input type="password" id="password-icon" name="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="••••••••" required>
                </div>
                <!-- Handle errors here -->
                @error('password')
                <p class="mt-2 px-1 text-sm text-red-600 dark:text-red-500"><span class="font-medium">خطأ!</span>
                    {{ $message }}
                </p>
                @enderror
            </div>

            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">تسجيل الدخول</button>

            <div class="mt-4 text-center">
                <!-- <a href="#" class="text-sm text-blue-600 hover:underline dark:text-blue-500">نسيت كلمة المرور؟</a> -->
            </div>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">ليس لديك حساب؟
                    <a href="/register" class="text-blue-600 hover:underline dark:text-blue-500">سجل الآن</a>
                </p>
            </div>
        </form>
    </div>
</x-layout>
