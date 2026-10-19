<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'role',
        'period',
        'badge_text',
        'description',
        'technologies',
        'display_order',
        'is_enabled',
    ];

    protected $casts = [
        'technologies' => 'array',
        'is_enabled' => 'boolean',
        'display_order' => 'integer',
    ];
}
