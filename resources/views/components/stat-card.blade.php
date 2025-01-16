@props(['icon', 'title', 'value', 'color' => 'gray'])

<div class="relative group">
    <!-- Gradient Glow Effect -->
    <div class="absolute -inset-0.5 bg-gradient-to-r from-{{ $color }}-500 to-{{ $color }}-700 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300"></div>

    <!-- Card Container -->
    <div class="relative bg-gray-100 dark:bg-gray-800/95 overflow-hidden rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 flex items-center" dir="rtl">
            <!-- Decorative Background Pattern -->
            <div class="absolute inset-0 opacity-5">
                <svg class="h-full w-full" viewBox="0 0 80 80" fill="none">
                    <path d="M14 16H10V28H14V16Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M34 16H30V28H34V16Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M54 16H50V28H54V16Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M74 16H70V28H74V16Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M14 36H10V48H14V36Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M34 36H30V48H34V36Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M54 36H50V48H54V36Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M74 36H70V48H74V36Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M14 56H10V68H14V56Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M34 56H30V68H34V56Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M54 56H50V68H54V56Z" fill="currentColor" fill-opacity="0.4"/>
                    <path d="M74 56H70V68H74V56Z" fill="currentColor" fill-opacity="0.4"/>
                </svg>
            </div>

            <!-- Icon Container -->
            <div class="relative flex-shrink-0">
                <!-- Icon Glow Effect -->
                <div class="absolute -inset-1 bg-{{ $color }}-500 rounded-full blur-sm opacity-30"></div>
                <!-- Icon Background -->
                <div class="relative bg-gradient-to-br from-{{ $color }}-50 to-{{ $color }}-100 dark:from-{{ $color }}-900 dark:to-{{ $color }}-800 p-3 rounded-full border border-{{ $color }}-200 dark:border-{{ $color }}-700 shadow-inner">
                    <!-- Lucide Icon -->
                    <i data-lucide="{{ $icon }}" class="h-6 w-6 text-{{ $color }}-500 dark:text-{{ $color }}-300"></i>
                </div>
            </div>

            <!-- Content Container -->
            <div class="mr-5 w-0 flex-1">
                <dl>
                    <!-- Title -->
                    <dt class="text-md font-medium truncate">
                        <span class="text-gray-950 dark:text-white">
                            {{ $title }}
                        </span>
                    </dt>
                    <!-- Value and Optional Slot (e.g., "new" or "unread") -->
                    <dd class="flex items-baseline mt-2">
                        <div class="flex items-center">
                            <span class="text-3xl font-extrabold text-{{ $color }}-600 dark:text-{{ $color }}-400">
                                {{ $value }}
                            </span>
                            @if(!empty($slot->toHtml()))
                                <span class="mr-2 px-2.5 py-0.5 text-sm bg-{{ $color }}-50 dark:bg-{{ $color }}-900/50 text-{{ $color }}-600 dark:text-{{ $color }}-400 rounded-full border border-{{ $color }}-200 dark:border-{{ $color }}-800">
                                    {{ $slot }}
                                </span>
                            @endif
                        </div>
                    </dd>
                </dl>
            </div>
        </div>

        <!-- Bottom Gradient Line -->
        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-{{ $color }}-500 to-{{ $color }}-700"></div>
    </div>
</div>
