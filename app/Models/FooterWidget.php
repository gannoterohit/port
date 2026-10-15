<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FooterWidget extends Model
{
    protected $fillable = [
        'title',
        'content',
        'is_enabled',
        'display_order',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'display_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => cache()->forget('public_footer_widgets'));
        static::deleted(fn () => cache()->forget('public_footer_widgets'));
    }

    public function links(): HasMany
    {
        return $this->hasMany(FooterLink::class)->orderBy('display_order');
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}
