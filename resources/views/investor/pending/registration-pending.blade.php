<!-- resources/views/investor/pending/registration-pending.blade.php -->
<x-layout title="Registration Pending">
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 px-4">
        <div class="w-full max-w-2xl p-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
            <div class="text-center">
                <!-- Pending Icon -->
                <div
                    class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                    <svg class="h-12 w-12 text-yellow-600 dark:text-yellow-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <!-- Status Message -->
                <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                    التسجيل قيد المراجعة
                </h2>

                <div class="mt-4 space-y-4">
                    <p class="text-gray-600 dark:text-gray-400">
                        تم تقديم رقم السجل التجاري الخاص بك وهو قيد الانتظار للموافقة من قبل فريق الإدارة.
                    </p>

                    <!-- Status Timeline -->
                    <div class="mt-8 max-w-md mx-auto">
                        <div class="relative">
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 h-full w-0.5 bg-gray-200 dark:bg-gray-700">
                            </div>

                            <!-- Submitted Step -->
                            <div class="relative flex items-center mb-8">
                                <div class="flex-1 text-right pr-4">
                                    <h3 class="font-medium text-gray-900 dark:text-white">تم تقديم التسجيل</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">مكتمل</p>
                                </div>
                                <div
                                    class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-green-500 rounded-full">
                                </div>
                                <div class="flex-1 pl-4"></div>
                            </div>

                            <!-- Under Review Step -->
                            <div class="relative flex items-center mb-8">
                                <div class="flex-1 text-right pr-4"></div>
                                <div
                                    class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-yellow-500 rounded-full">
                                </div>
                                <div class="flex-1 pl-4">
                                    <h3 class="font-medium text-gray-900 dark:text-white">قيد المراجعة</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">قيد التنفيذ</p>
                                </div>
                            </div>

                            <!-- Approval Step -->
                            <div class="relative flex items-center">
                                <div class="flex-1 text-right pr-4">
                                    <h3 class="font-medium text-gray-900 dark:text-white">الموافقة النهائية</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">قيد الانتظار</p>
                                </div>
                                <div
                                    class="absolute left-1/2 transform -translate-x-1/2 w-4 h-4 bg-gray-300 dark:bg-gray-600 rounded-full">
                                </div>
                                <div class="flex-1 pl-4"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mt-8 p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            ستتلقى إشعارًا عبر البريد الإلكتروني بمجرد الموافقة على تسجيلك.
                            تستغرق هذه العملية عادةً من 1 إلى 2 يوم عمل.
                        </p>
                    </div>

                    <!-- Logout Option -->
                    <div class="mt-6">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white ">
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function checkRegistrationStatus() {
                fetch('{{ route("check.registration.status") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'approved') {
                            window.location.href = '{{ route("investor.home") }}';
                        } else if (data.status === 'rejected') {
                            window.location.href = '{{ route("commercial-registration.create") }}';
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Check every 30 seconds
            setInterval(checkRegistrationStatus, 10000);

            // Also check immediately when page loads
            checkRegistrationStatus();
        </script>
    @endpush

</x-layout>
