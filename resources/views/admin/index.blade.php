<x-layout title="Admin Dashboard">

    <div class="flex flex-col gap-4 px-2">
        <x-page-header>لوحة التحكم</x-page-header>

        <!-- Stats Grid -->
        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4" dir="rtl">
            <!-- Total Users -->
            <x-stat-card icon="users" title="إجمالي المستخدمين" value="{{ $stats['total_users'] }}" color="purple" />

            <!-- Pending Investors -->
            <x-stat-card icon="clock" title="المستثمرون " value="{{ $stats['pending_registrations'] }}" color="yellow">
                <span>قيد الانتظار</span>
            </x-stat-card>

            <!-- Pending Ideas -->
            <x-stat-card icon="lightbulb" title="الأفكار " value="{{ $stats['pending_ideas'] ?? 0 }}" color="blue">
                <span>قيدالانتظار</span>
            </x-stat-card>

            <!-- Inbox -->
            <x-stat-card icon="inbox" title="صندوق الوارد" value="{{ $stats['inbox_count'] ?? 2 }}" color="green">
                <span>غير مقروء</span>
            </x-stat-card>
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
            <a href="{{ route('admin.investors.index') }}"
                class="text-sm font-medium text-blue-700 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
               <span class="font-extrabold text-lg">→ </span>  استعرض جميع المستثمرون
            </a>
        </div>
    </div>
</x-layout>
