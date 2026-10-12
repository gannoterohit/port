<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnquiryStatusLog extends Model
{
    protected $fillable = [
        'enquiry_id',
        'status',
        'user_id',
        'note',
    ];

    public function enquiry(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
