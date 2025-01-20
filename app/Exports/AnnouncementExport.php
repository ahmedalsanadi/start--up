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
            'approval_status' => 'الحالة',
            'created_at' => 'تاريخ الإنشاء',
        ];
    }
}
