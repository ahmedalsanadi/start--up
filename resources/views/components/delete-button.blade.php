<!-- views/components/delete-button.blade.php -->
@props([
    'deleteUrl' => '#',
    'deleteConfirmMessage' => 'Are you sure you want to delete this item?',
])

            <!-- Trash Icon: Delete -->


            <button type="submit" data-delete-url="{{ $deleteUrl }}" data-delete-message="{{ $deleteConfirmMessage }}"
            class=" delete-btn text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
