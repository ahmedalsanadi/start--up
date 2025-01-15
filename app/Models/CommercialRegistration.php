<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommercialRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'registration_number',
        'status',
        'admin_notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
