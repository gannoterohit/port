<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class WorkProcess extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'display_order',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'display_order' => 'integer',
    ];

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon ? Storage::url($this->icon) : null;
    }
}
