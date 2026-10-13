<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'client_name',
        'thumbnail',
        'thumbnail_alt',
        'tech_stack',
        'purpose',
        'key_features',
        'role',
        'challenges',
        'solutions',
        'demo_url',
        'github_url',
        'is_featured',
        'status',
        'display_order',
        'seo_title',
        'seo_description',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'no_index',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'no_index' => 'boolean',
        'tech_stack' => 'array',
        'published_at' => 'datetime',
        'display_order' => 'integer',
    ];

    public function screenshots(): HasMany
    {
        return $this->hasMany(ProjectScreenshot::class)->orderBy('display_order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'published' ? 'Published' : 'Draft';
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? asset('storage/'.$this->thumbnail) : null;
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ? asset('storage/'.$this->og_image) : null;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        return $this->description ? Str::limit(strip_tags($this->description), 160) : null;
    }

    public function getProjectTypeAttribute(): string
    {
        return $this->category ?? 'Uncategorized';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    protected static function booted()
    {
        static::creating(function ($project) {
            if (! $project->slug) {
                $project->slug = Str::slug($project->title);
            }
        });
    }
}
