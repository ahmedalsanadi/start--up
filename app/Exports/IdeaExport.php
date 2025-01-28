<?php

namespace App\Exports;

use App\Models\Idea;
use Illuminate\Support\Collection;

class IdeaExport extends BaseExport
{
    public static function getDefaultColumns(): array
    {
        return [
            'id' => 'الرقم التعريفي',
            'name' => 'اسم الفكرة',
            'brief_description' => 'الوصف المختصر',
            'detailed_description' => 'الوصف التفصيلي',
            'budget' => 'الميزانية',
            'location' => 'الموقع',
            'idea_type' => 'نوع الفكرة',
            'feasibility_study' => 'دراسة الجدوى',
            'entrepreneur.name' => 'رائد الأعمال',
            'announcement.name' => 'الإعلان المرتبط',
            'approval_status' => 'حالة الموافقة',
            'rejection_reason' => 'سبب الرفض',
            'status' => 'حالة الفكرة',
            'expiry_date' => 'تاريخ الانتهاء',
            'stage' => 'المرحلة',
            'is_reusable' => 'قابل لإعادة الاستخدام',
            'created_at' => 'تاريخ الإنشاء',
            'updated_at' => 'تاريخ التحديث',
        ];
    }

    public function __construct(Collection $data)
    {
        parent::__construct($data, self::getDefaultColumns());
    }

    protected function formatValue($row, $column)
    {
        $value = data_get($row, $column);

        // Handle dates
        if (str_contains($column, 'date') || $column === 'created_at' || $column === 'updated_at') {
            return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d H:i') : '';
        }

        // Handle status translations
        if ($column === 'status') {
            return match ($value) {
                'pending' => 'معلق',
                'approved' => 'مقبول',
                'rejected' => 'مرفوض',
                'in-progress' => 'جاري',
                'completed' => 'مكتمل',
                'deleted_by_entrepreneur' => 'محذوف',
                'deleted_by_investor' => 'محذوف',
                'expired' => 'منتهي',
                default => $value,
            };
        }

        // Handle approval status translations
        if ($column === 'approval_status') {
            return match ($value) {
                'pending' => 'معلق',
                'approved' => 'مقبول',
                'rejected' => 'مرفوض',
                default => $value,
            };
        }

        // Handle idea type
        if ($column === 'idea_type') {
            return $value === 'creative' ? 'إبداعية' : 'تقليدية';
        }

        // Handle stage
        if ($column === 'stage') {
            return match ($value) {
                'new' => 'جديدة',
                'initial_acceptance' => 'قبول أولي',
                'under_review' => 'قيد المراجعة',
                'expert_consultation' => 'استشارة الخبراء',
                'final_decision' => 'قرار نهائي',
                default => $value,
            };
        }

        // Handle is_reusable
        if ($column === 'is_reusable') {
            return $value ? 'نعم' : 'لا';
        }

        return $value;
    }
}
