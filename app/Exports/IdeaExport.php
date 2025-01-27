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
        // Pass the data and default columns to the BaseExport constructor
        parent::__construct($data, self::getDefaultColumns());
    }

    // Override the formatValue method to handle custom formatting
    protected function formatValue($row, $column)
    {
        $value = parent::formatValue($row, $column);

        // Handle approval_status column
        if ($column === 'approval_status') {
            return $this->translateApprovalStatus($value);
        }

        // Handle status column
        if ($column === 'status') {
            return $this->translateStatus($value);
        }

        // Handle idea_type column
        if ($column === 'idea_type') {
            return $this->translateIdeaType($value);
        }

        // Handle stage column
        if ($column === 'stage') {
            return $this->translateStage($value);
        }

        // Handle is_reusable column
        if ($column === 'is_reusable') {
            return $value ? 'نعم' : 'لا';
        }

        return $value;
    }

    // Helper methods to translate values into Arabic
    protected function translateIdeaType($type)
    {
        return $type === 'creative' ? 'إبداعية' : 'تقليدية';
    }

    protected function translateApprovalStatus($status)
    {
        switch ($status) {
            case 'pending':
                return 'قيد المراجعة';
            case 'approved':
                return 'مقبولة';
            case 'rejected':
                return 'مرفوضة';
            default:
                return $status;
        }
    }

    protected function translateStatus($status)
    {
        switch ($status) {
            case 'in-progress':
                return 'قيد التنفيذ';
            case 'approved':
                return 'مقبولة';
            case 'rejected':
                return 'مرفوضة';
            case 'deleted_by_entrepreneur':
                return 'محذوفة من قبل رائد الأعمال';
            case 'expired':
                return 'منتهية الصلاحية';
            default:
                return $status;
        }
    }

    protected function translateStage($stage)
    {
        switch ($stage) {
            case 'new':
                return 'جديدة';
            case 'initial_acceptance':
                return 'قبول أولي';
            case 'under_review':
                return 'قيد المراجعة';
            case 'expert_consultation':
                return 'استشارة الخبراء';
            case 'final_decision':
                return 'قرار نهائي';
            default:
                return $stage;
        }
    }
}
