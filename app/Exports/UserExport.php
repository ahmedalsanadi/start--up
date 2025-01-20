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
            'created_at' => 'تاريخ التسجيل',
        ];
    }
}
