<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'ip_address',
        'page_url',
        'page_title',
        'route_name',
        'method',
        'referer',
        'referer_host',
        'device_type',
        'browser',
        'os',
        'country',
        'city',
        'user_agent',
        'session_id',
        'is_bot',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
    ];

    public function scopeRealVisitors(Builder $query): Builder
    {
        return $query->where('is_bot', false);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function getCleanRefererAttribute(): string
    {
        return $this->referer_host ?: 'Direct';
    }

    public function getLocationLabelAttribute(): string
    {
        if ($this->city && $this->country) {
            return "{$this->city}, {$this->country}";
        }

        return $this->country ?: ($this->city ?: 'Local / Private');
    }
}

