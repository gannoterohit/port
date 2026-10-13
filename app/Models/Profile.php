<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'title',
        'subtitle',
        'intro',
        'biography',
        'experience_text',
        'profile_photo',
        'resume_pdf',
        'resume_button_visible',
        'location',
        'location_visible',
        'contact_email',
        'contact_phone',
        'contact_whatsapp',
        'social_links',
        'og_image',
    ];

    protected $casts = [
        'social_links' => 'array',
        'resume_button_visible' => 'boolean',
        'location_visible' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    public function getFirstNameAttribute(): string
    {
        return explode(' ', $this->name)[0] ?? $this->name;
    }

    public function getLastNameAttribute(): string
    {
        $parts = explode(' ', $this->name, 2);

        return count($parts) > 1 ? $parts[1] : '';
    }

    public function getBioAttribute(): ?string
    {
        return $this->biography ?? $this->intro;
    }

    public function getEmailAttribute(): ?string
    {
        return $this->contact_email;
    }

    public function getPhoneAttribute(): ?string
    {
        return $this->contact_phone;
    }

    public function getWebsiteAttribute(): ?string
    {
        return $this->social_links['website'] ?? null;
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo ? Storage::url($this->profile_photo) : null;
    }

    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume_pdf ? Storage::url($this->resume_pdf) : null;
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ? asset('storage/'.$this->og_image) : null;
    }

    public function getSocialLinksArrayAttribute(): array
    {
        return $this->social_links ?? [];
    }

    public function socialLink(string $platform): ?string
    {
        $links = $this->social_links ?? [];

        return $links[$platform] ?? null;
    }

    public static function getInstance(): self
    {
        return self::firstOrCreate([], [
            'name' => 'Your Name',
            'title' => 'Full Stack Web Developer',
            'subtitle' => '2.5+ years professional experience',
            'intro' => 'Passionate developer building web applications.',
            'biography' => 'Detailed biography here.',
            'experience_text' => '2.5 years professional experience + 6 months training',
            'contact_email' => 'hello@example.com',
        ]);
    }
}
