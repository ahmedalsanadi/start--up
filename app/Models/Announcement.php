<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    /** @use HasFactory<\Database\Factories\AnnouncementFactory> */
    use HasFactory;

    protected $fillable = [
        'description',
        'location',
        'start_date',
        'end_date',
        'budget',
        'investor_id',
        'approval_status',
        'rejection_reason',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime', // Cast start_date to a Carbon instance
        'end_date' => 'datetime',   // Cast end_date to a Carbon instance (if needed)
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
    public function ideas(): HasMany
    {
        return $this->hasMany(Idea::class);
    }

}
