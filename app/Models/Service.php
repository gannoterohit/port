<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'features',
        'cta_text',
        'cta_url',
        'price',
        'is_enabled',
        'is_featured',
        'display_order',
        'seo_title',
        'seo_description',
        'og_title',
        'og_description',
        'og_image',
        'canonical_url',
        'no_index',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_featured' => 'boolean',
        'no_index' => 'boolean',
        'features' => 'array',
        'display_order' => 'integer',
    ];

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

    public function getTitleAttribute(): string
    {
        return $this->name;
    }

    public function getShortDescriptionAttribute(): ?string
    {
        return $this->description ? Str::limit(strip_tags($this->description), 120) : null;
    }

    public function getPriceFormattedAttribute(): ?string
    {
        // Prices are intentionally hidden — quotes are given after scoping the project.
        return null;
    }

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon ? asset('storage/'.$this->icon) : null;
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/'.$this->image) : null;
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ? asset('storage/'.$this->og_image) : null;
    }

    protected static function booted()
    {
        static::creating(function ($service) {
            if (! $service->slug) {
                $service->slug = Str::slug($service->name);
            }
        });
    }
}
