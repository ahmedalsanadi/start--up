    <!-- Reject Announcement Modal -->
    <div id="rejectAnnouncementModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Card Container -->
            <div
                class="bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-right sm:w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            سبب الرفض
                        </h3>
                        <div class="mt-2">
                            <form id="rejectAnnouncementForm" action="" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="approval_status" value="rejected">
                                <textarea name="rejection_reason"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    rows="4" required></textarea>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="submit" form="rejectAnnouncementForm"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        تأكيد الرفض
                    </button>
                    <button type="button" onclick="closeRejectModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openRejectModal(announcementId) {
                const modal = document.getElementById('rejectAnnouncementModal');
                const form = document.getElementById('rejectAnnouncementForm');
                form.action = `/admin/announcements/${announcementId}/update-status`;
                modal.classList.remove('hidden');
            }

            function closeRejectModal() {
                const modal = document.getElementById('rejectAnnouncementModal');
                modal.classList.add('hidden');
            }

            function viewDetails(announcementId) {
                // Implement view details functionality
                window.location.href = `/admin/announcements/${announcementId}`;
            }
        </script>
    @endpush
