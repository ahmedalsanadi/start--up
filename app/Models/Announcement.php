<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Announcement extends Model
{
    /** @use HasFactory<\Database\Factories\AnnouncementFactory> */
    use HasFactory;

    protected $fillable = [
        'description', 'location', 'start_date', 'end_date', 'budget', 'investor_id',
        'approval_status', 'rejection_reason', 'status',
    ];

    // Relationship with Investor (User)
    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'investor_id');
    }

    // Relationship with Categories
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'announcement_category');
    }
}
