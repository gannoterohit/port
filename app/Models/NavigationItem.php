<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    protected $fillable = [
        'label',
        'url',
        'target',
        'is_visible',
        'display_order',
        'nav_type',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'display_order' => 'integer',
    ];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function scopeHeader($query)
    {
        return $query->where('nav_type', 'header');
    }

    public function getTargetAttribute(): string
    {
        return $this->attributes['target'] ?? '_self';
    }
}
