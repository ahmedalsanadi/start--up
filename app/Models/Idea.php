<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Idea extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'brief_description', 'detailed_description', 'budget', 'image', 'location',
        'idea_type', 'feasibility_study', 'entrepreneur_id', 'announcement_id',
        'approval_status', 'rejection_reason', 'status', 'expiry_date',
    ];

    // Relationship with Entrepreneur (User)
    public function entrepreneur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entrepreneur_id');
    }

    // Relationship with Announcement (for creative ideas)
    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    // Relationship with Categories
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'idea_category');
    }

    // Relationship with Idea Stages
    public function stages(): HasMany
    {
        return $this->hasMany(IdeaStage::class);
    }
}
