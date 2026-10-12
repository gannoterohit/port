<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'ip_address',
        'user_agent',
        'internal_notes',
        'read_at',
        'replied_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    public function statusLogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EnquiryStatusLog::class)->orderBy('created_at', 'desc');
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'new' => 'New',
            'in_progress' => 'In Progress',
            'contacted' => 'Contacted',
            'converted' => 'Converted',
            'closed' => 'Closed',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        $colors = [
            'new' => 'blue',
            'in_progress' => 'yellow',
            'contacted' => 'green',
            'converted' => 'purple',
            'closed' => 'gray',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    public function scopeByStatus($query, string $status)
    {
        if ($status && $status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeSearch($query, ?string $term)
    {
        if ($term) {
            return $query->where(function ($q) use ($term) {
                $q->where('name', 'like', '%' . $term . '%')
                    ->orWhere('email', 'like', '%' . $term . '%')
                    ->orWhere('phone', 'like', '%' . $term . '%')
                    ->orWhere('subject', 'like', '%' . $term . '%')
                    ->orWhere('message', 'like', '%' . $term . '%');
            });
        }
        return $query;
    }
}
