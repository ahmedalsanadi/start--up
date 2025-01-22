@props(['icon', 'title', 'value', 'color' => 'gray'])


<!-- Total Users Card -->
<div class="relative group">
    <!-- Gradient Glow Effect -->
    <div
        class="absolute -inset-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300">
    </div>

    <div
        class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col gap-1 p-4">
            <P class="text-gray-950 dark:text-blue-200 text-md font-medium truncate">
                {{ $title }}
            </P>
            <div class="flex items-center justify-between px-4 ">
                <div>
                    <h3 class="text-3xl font-bold text-gray-950 dark:text-{{ $color }}-200 ">
                        {{ $value }}
                    </h3>
                </div>

                <!-- Icon -->
                <div class="relative ">
                    <!-- Glowing Effect -->
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full blur-sm opacity-30">
                    </div>
                    <!-- Icon Container -->
                    <div
                        class="relative bg-gradient-to-br from-white to-{{ $color }}-200 dark:from-{{ $color }}-900 dark:to-gray-800 p-3 rounded-full border border-{{ $color }}-300 dark:border-{{ $color }}-700 shadow-inner">
                        <!-- Lucide Icon -->
                        <i data-lucide="{{ $icon }}"
                            class="h-6 w-6 text-{{ $color }}-500 dark:text-{{ $color }}-300"></i>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-gray-500 to-gray-300 dark:from-purple-600  dark:to-gray-800">
        </div>
    </div>
</div>
