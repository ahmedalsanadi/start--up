<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdeaStage extends Model
{
    protected $fillable = ['idea_id', 'stage', 'changed_at'];

    // Relationship with Idea
    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
}
