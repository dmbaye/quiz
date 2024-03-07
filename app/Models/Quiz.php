<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'quiz_user')
            ->withPivot('score', 'is_completed', 'is_attempted')
            ->withTimestamps();
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', 1);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_archived', 0);
    }

    public function scopeArchived(Builder $query): void
    {
        $query->where('is_archived', 1);
    }

    public function scopeCompleted(Builder $query): void
    {
        $query->where('is_completed', 1);
    }

    public function scopeUncompleted(Builder $query): void
    {
        $query->where('is_completed', 0);
    }
}
