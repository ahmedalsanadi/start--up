<?php

namespace App\Exports;

use App\Models\CommercialRegistration;
use Illuminate\Support\Collection;

class CommercialRegistrationExport extends BaseExport
{
    public static function getDefaultColumns(): array
    {
        return [
            'id' => 'الرقم التعريفي',
            'user.name' => 'المستثمر',
            'registration_number' => 'رقم السجل التجاري',
            'status' => 'الحالة',
            'created_at' => 'تاريخ التسجيل',
            'reviewed_at' => 'تاريخ المراجعة',
            'reviewed_by.name' => 'تمت المراجعة بواسطة',
        ];
    }

    protected function formatValue($row, $column)
    {
        $value = data_get($row, $column);

        // Handle reviewedBy relationship
        if ($column === 'reviewed_by.name') {
            return $row->reviewedBy ? $row->reviewedBy->name : 'لم تتم المراجعة بعد';
        }

        // Add custom formatting based on column type
        if (str_contains($column, 'date') || $column === 'created_at' || $column === 'reviewed_at') {
            return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i') : '';
        }

        if ($column === 'status') {
            return $this->formatStatus($value); // Format status
        }

        return $value;
    }
    protected function formatStatus($value)
    {
        switch ($value) {
            case 'pending':
                return 'قيد المراجعة';
            case 'approved':
                return 'مقبول';
            case 'rejected':
                return 'مرفوض';
            default:
                return 'غير معروف';
        }
    }
}
