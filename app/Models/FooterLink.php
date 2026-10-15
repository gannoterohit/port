<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FooterLink extends Model
{
    protected $fillable = [
        'footer_widget_id',
        'label',
        'url',
        'target',
        'display_order',
        'link_type',
    ];

    protected $casts = [
        'display_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => cache()->forget('public_orphaned_footer_links'));
        static::deleted(fn () => cache()->forget('public_orphaned_footer_links'));
    }

    public function widget(): BelongsTo
    {
        return $this->belongsTo(FooterWidget::class, 'footer_widget_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function scopeOrphaned($query)
    {
        return $query->whereNull('footer_widget_id');
    }
}
