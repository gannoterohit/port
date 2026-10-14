<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'show_in_nav',
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
        'show_in_nav' => 'boolean',
        'no_index' => 'boolean',
        'display_order' => 'integer',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeVisibleInNav($query)
    {
        return $query->where('show_in_nav', true)->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'published' ? 'Published' : 'Draft';
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ? Storage::disk('public')->url($this->og_image) : null;
    }

    protected static function booted()
    {
        static::creating(function ($page) {
            if (! $page->slug) {
                $page->slug = Str::slug($page->title);
            }
        });
    }
}
