<!-- resources/views/components/commericial-review-modal.blade.php -->

    <!-- Review Modal -->
    <div id="reviewModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-6 w-96 shadow-xl rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <!-- Modal Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                تحديث حالة التسجيل
            </h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form id="updateForm" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <!-- Status Dropdown -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">الحالة</label>
                <select name="status" id="status" class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition duration-200"
                        onchange="toggleRejectionReason()">
                    <option value="approved">قبول</option>
                    <option value="rejected">رفض</option>
                </select>
            </div>

            <!-- Rejection Reason (Hidden by Default) -->
            <div id="rejectionReasonDiv" class="hidden">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">سبب الرفض</label>
                <textarea name="rejection_reason"
                          class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition duration-200"
                          rows="3"
                          placeholder="أدخل سبب الرفض..."></textarea>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200">
                    إلغاء
                </button>
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-200">
                    تحديث
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
        function openModal(registrationId) {
            document.getElementById('reviewModal').classList.remove('hidden');
            document.getElementById('updateForm').action = `/admin/commercial-registrations/${registrationId}`;
        }

        function closeModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }

        function toggleRejectionReason() {
            const status = document.getElementById('status').value;
            const rejectionDiv = document.getElementById('rejectionReasonDiv');
            rejectionDiv.classList.toggle('hidden', status !== 'rejected');
        }
    </script>
@endpush
