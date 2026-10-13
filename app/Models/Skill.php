<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'proficiency',
        'display_order',
        'is_enabled',
        'is_featured',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_featured' => 'boolean',
        'display_order' => 'integer',
        'proficiency' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class, 'category_id');
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function getProficiencyLabelAttribute(): string
    {
        if (! $this->proficiency) {
            return '';
        }

        $levels = [
            1 => 'Beginner',
            2 => 'Basic',
            3 => 'Intermediate',
            4 => 'Advanced',
            5 => 'Expert',
        ];

        return $levels[$this->proficiency] ?? '';
    }
}
