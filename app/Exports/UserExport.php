<?php

namespace App\Exports;

use App\Models\User;

class UserExport extends BaseExport
{
    public static function getDefaultColumns(): array
    {
        return [
            'id' => 'الرقم التعريفي',
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'user_type' => 'نوع المستخدم',
            'is_active' => 'الحالة',
            'created_at' => 'تاريخ التسجيل',
            'announcements_count' => 'عدد الإعلانات', // For investors
            'ideas_count' => 'عدد الأفكار', // For entrepreneurs
        ];
    }

    protected function formatValue($row, $column)
    {
        $value = data_get($row, $column);

        // Add custom formatting based on column type
        if (str_contains($column, 'date') || $column === 'created_at' || $column === 'updated_at') {
            return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i') : '';
        }

        if ($column === 'user_type') {
            return $this->formatUserType($value); // Format user type
        }

        if ($column === 'is_active') {
            return $value ? 'نشط' : 'غير نشط'; // Format active status
        }

        return $value;
    }

    protected function formatUserType($value)
    {
        switch ($value) {
            case 1:
                return 'مدير';
            case 2:
                return 'مستثمر';
            case 3:
                return 'رائد أعمال';
            default:
                return 'غير معروف';
        }
    }
}
