<x-layout title="Admin Dashboard">

    <div class="flex flex-col gap-4 px-2">
        <x-page-header>Dashboard</x-page-header>

<!-- Stats Grid -->
<!-- Stats Grid -->
<div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4" dir="rtl">
    <!-- Total Users -->
    <x-stat-card
        icon="users"
        title="إجمالي المستخدمين"
        value="{{ $stats['total_users'] }}"
        color="purple"
    />

    <!-- Pending Investors -->
    <x-stat-card
        icon="clock"
        title="المستثمرون المنتظرون"
        value="{{ $stats['pending_registrations'] }}"
        color="yellow"
    />

    <!-- Pending Ideas -->
    <x-stat-card
        icon="lightbulb"
        title="الأفكار المنتظرة"
        value="{{ $stats['pending_ideas'] ?? 0 }}"
        color="blue"
    >
        <span>جديد</span>
    </x-stat-card>

    <!-- Inbox -->
    <x-stat-card
        icon="inbox"
        title="صندوق الوارد"
        value="{{ $stats['inbox_count'] ?? 2 }}"
        color="green"
    >
        <span>غير مقروء</span>
    </x-stat-card>
</div>

        <!-- Pending Registrations List -->
        <x-list title="Recent Pending Registrations">
            @forelse($pendingRegistrations as $registration)
                <x-list-item :user="$registration->user" :registration="$registration" />
            @empty
                <li>
                    <div class="px-4 py-4 sm:px-6">
                        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                            No pending registrations found.
                        </div>
                    </div>
                </li>
            @endforelse
        </x-list>

        <div class="px-4 py-3 bg-gray-100 dark:bg-gray-700 text-right sm:px-6">
            <a href="{{ route('admin.investors.index') }}"
                class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300">
                View all registrations →
            </a>
        </div>

    </div>
</x-layout>
