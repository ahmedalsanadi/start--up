<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommercialRegistration extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    // Relationship with the user who submitted the registration
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with the admin who reviewed the registration
    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
