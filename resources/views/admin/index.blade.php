<x-layout title="Admin Dashboard">

    <div class="flex flex-col gap-4 px-2">
        <x-page-header>لوحة التحكم</x-page-header>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <!-- Total Users -->
            <x-stat-card icon="users" title="إجمالي المستخدمين" value="{{ $stats['total_users'] }}" color="purple" />

            <x-stat-card icon="megaphone" title="إجمالي الإعلانات" value="{{ $stats['announcements'] ?? 0 }}"
                color="yellow" />


            <!-- Pending Ideas -->
            <x-stat-card icon="lightbulb" title="إجمالي الافكار" value="{{ $stats['total_ideas'] ?? 0 }}"
                color="blue" />

            <!-- Inbox -->
            <x-stat-card icon="inbox" title="صندوق الاشعارات" value="{{Auth::user()->unreadNotifications()->count()}}"
                color="green" />

        </div>

        <!-- Pending Registrations List -->
        <x-list title="المستثمرون المسجلون مؤخرا">
            @forelse($pendingRegistrations as $registration)
                <x-list-item :user="$registration->user" :registration="$registration" />
            @empty
                <li>
                    <div class="px-4 py-4 sm:px-6">
                        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                            لا يوجد مستثمرون مسجلون مؤخرا
                        </div>
                    </div>
                </li>
            @endforelse
        </x-list>

        <div class="px-4 py-3 bg-gray-100 dark:bg-gray-800 text-right sm:px-6">
            <a href="{{ route('admin.commerical-registrations.index') }}"
                class="text-sm font-medium text-blue-700 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                <span class="font-extrabold text-lg">→ </span> استعرض جميع المستثمرون
            </a>
        </div>
    </div>


</x-layout>
