<!-- Delete Confirmation Modal -->
<div id="deleteModal"
    class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full  transition-opacity duration-300 ease-in-out">
    <div class="relative mx-auto w-full max-w-md p-1">
        <div
            class="relative bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-blue-50 dark:bg-blue-900/20 rounded-full -translate-y-32 translate-x-32 blur-3xl">
            </div>

            <div class="relative p-6 text-center" dir="rtl">
                <div
                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30 mb-4">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>

                <h3  id="deleteMessage" class="text-lg leading-6 font-bold text-gray-900 dark:text-white mb-2"
                data-default-message="هل أنت متأكد من أنك تريد حذف هذا العنصر؟ لا يمكن التراجع عن هذا الإجراء.">
                    هل أنت متأكد أنك تريد حذف هذا العنصر ؟
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    لن تتمكن من استعادة هذا الإعلان بعد الحذف.
                </p>
                <div class="flex justify-center gap-3">
                    <form id="deleteForm" method="POST" class="flex gap-3">
                        @csrf
                        @method('DELETE')


                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg transition-all duration-200 shadow-lg hover:shadow-red-500/25">
                            حذف
                        </button>
                        <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 hover:from-gray-300 hover:to-gray-400 dark:hover:from-gray-600 dark:hover:to-gray-700 rounded-lg transition-all duration-200">
                            إلغاء
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
