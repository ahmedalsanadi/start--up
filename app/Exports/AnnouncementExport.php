<?php

namespace App\Exports;

use App\Models\Announcement;

class AnnouncementExport extends BaseExport
{
    public static function getDefaultColumns(): array
    {
        return [
            'id' => 'الرقم التعريفي',
            'investor.name' => 'المستثمر',
            'description' => 'الوصف',
            'location' => 'الموقع',
            'budget' => 'الميزانية',
            'approval_status' => 'حالة الموافقة',
            'created_at' => 'تاريخ الإنشاء',
            'status' => 'الحالة',
        ];
    }

    protected function formatValue($row, $column)
    {
        $value = data_get($row, $column);

        if ($column === 'status') {
            return match ($value) {
                'in-progress' => 'جاري',
                'completed' => 'مكتملة',
                'deleted_by_investor' => 'محذوفة من قبل المستثمر',
                'deleted_by_entrepreneur' => 'محذوفة من قبل رائد الأعمال',
                default => $value,
            };
        }

        if ($column === 'approval_status') {
            return match ($value) {
                'pending' => 'قيد المراجعة',
                'approved' => 'مقبولة',
                'rejected' => 'مرفوضة',
                default => $value,
            };
        }

        return parent::formatValue($row, $column);
    }

    public function __construct($data)
    {
        parent::__construct($data, static::getDefaultColumns());
    }
}
