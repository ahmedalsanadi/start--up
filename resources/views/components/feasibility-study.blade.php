@props(['feasibilityStudy'])

@if ($feasibilityStudy)
    <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">دراسة الجدوى</h2>
        <div class="flex flex-col sm:flex-row items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg gap-4 sm:gap-6">
            <!-- File Info -->
            <div class="flex items-center gap-3 flex-1">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                    <i data-lucide="file-text" class="w-6 h-6 text-blue-500 dark:text-blue-400"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">دراسة الجدوى.pdf</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">PDF Document</p>
                </div>
            </div>

            <!-- Download Button -->
            <a href="{{ filter_var($feasibilityStudy, FILTER_VALIDATE_URL) ? $feasibilityStudy : asset('storage/' . $feasibilityStudy) }}"
                target="_blank"
                class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors duration-200">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                تحميل
            </a>
        </div>
    </div>
@endif
