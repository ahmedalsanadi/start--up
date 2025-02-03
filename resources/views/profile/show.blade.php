<x-layout title="الصفحة الشخصية">
@php
    // Determine the image source
    if (empty($user->profile_image)) {
        // If no image is provided, use the default avatar
        $imageSrc = '/default-avatar.jpg';
    } else
    {
        // Check if the image is a URL
        if (filter_var($src, FILTER_VALIDATE_URL)) {
            // If it's a URL, use it directly
            $imageSrc = $ $user->profile_image;
        } else {
            // If it's not a URL, assume it's stored locally and prepend the storage path
            $imageSrc = asset('storage/' . $user->profile_image);
        }
    }
@endphp
    <div class="space-y-8">
<!-- Profile Header -->
<div class="relative">
    <div class="h-32 bg-gradient-to-r from-blue-600 to-blue-800 rounded-t-2xl"></div>
    <div class="absolute bottom-0 left-8 transform translate-y-1/2">
        <div class="relative">
            <img src="{{ $imageSrc }}"
                 alt="{{ $user->name }}"
                 class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
            <div class="absolute bottom-0 right-0 transform translate-x-1/4">
                <!-- Edit Profile Icon -->
                <a href="{{ route('profile.edit', ['profile' => $user->id]) }}">
                    <i data-lucide="edit" class="w-8 h-8 text-white bg-blue-600 p-2 rounded-full hover:bg-blue-800 shadow-lg hover:scale-110 transition-all duration-300 ease-in-out transform hover:rotate-12"></i>
                </a>
            </div>
        </div>
    </div>
</div>

        <!-- User Info Section -->
        <div class="mt-20 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Info Card -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                        <p class="text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-lg text-sm font-semibold
                        @if($user->isAdmin()) bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100
                        @elseif($user->isInvestor()) bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                        @else bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100 @endif">
                        {{ $user->getUserTypeLabel() }}
                    </span>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">رقم الهاتف</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->phone_number ?? 'غير محدد' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">المدينة</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->city ?? 'غير محدد' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">العنوان</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->address ?? 'غير محدد' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 space-x-reverse">
                        <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">تاريخ التسجيل</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->created_at->format('Y-m-d') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">إحصائيات</h3>
                <div class="space-y-4">
                    @if($user->isInvestor())
                        @foreach($statistics as $key => $value)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">
                                    @switch($key)
                                        @case('total_announcements')
                                            إجمالي الإعلانات
                                            @break
                                        @case('active_announcements')
                                            الإعلانات النشطة
                                            @break
                                        @case('completed_announcements')
                                            الإعلانات المكتملة
                                            @break
                                        @case('total_budget')
                                            إجمالي الميزانية
                                            @break
                                    @endswitch
                                </span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $key === 'total_budget' ? number_format($value, 2) . ' ريال' : $value }}</span>
                            </div>
                        @endforeach
                    @elseif($user->isEntrepreneur())
                        @foreach($statistics as $key => $value)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">
                                    @switch($key)
                                        @case('total_ideas')
                                            إجمالي الأفكار
                                            @break
                                        @case('approved_ideas')
                                            الأفكار المعتمدة
                                            @break
                                        @case('pending_ideas')
                                            الأفكار قيد المراجعة
                                            @break
                                        @case('total_budget_requested')
                                            إجمالي الميزانية المطلوبة
                                            @break
                                    @endswitch
                                </span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $key === 'total_budget_requested' ? number_format($value, 2) . ' ريال' : $value }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Information Based on User Type -->
        @if($user->isInvestor())
            <!-- Commercial Registration Section -->
            @if($user->commercialRegistration)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">معلومات السجل التجاري</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">رقم السجل</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $user->commercialRegistration->registration_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">الحالة</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($user->commercialRegistration->status === 'approved') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                            @elseif($user->commercialRegistration->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                            @else bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 @endif">
                            {{ __($user->commercialRegistration->status) }}
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Announcements Section -->
            @if($user->announcements->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">الإعلانات</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الوصف</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الموقع</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الميزانية</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($user->announcements as $announcement)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ Str::limit($announcement->description, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ $announcement->location }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">{{ number_format($announcement->budget, 2) }} ريال</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($announcement->status === 'completed') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                        @elseif($announcement->status === 'in-progress') bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                        @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100 @endif">
                                        {{ __($announcement->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        @elseif($user->isEntrepreneur())
            <!-- Ideas Section -->
            @if($user->ideas->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">الأفكار</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($user->ideas as $idea)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-900 dark:text-white">{{ $idea->name }}</h4>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($idea->approval_status === 'approved') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                @elseif($idea->approval_status === 'rejected') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                @else bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100 @endif">
                                {{ __($idea->approval_status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ Str::limit($idea->brief_description, 100) }}</p>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 dark:text-gray-400">الميزانية: {{ number_format($idea->budget, 2) }} ريال</span>
                            <span class="text-gray-500 dark:text-gray-400">{{ $idea->idea_type }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif
    </div>
</x-layout>
