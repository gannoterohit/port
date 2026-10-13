<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $fillable = [
        'hero_heading',
        'hero_title',
        'hero_description',
        'hero_image',
        'primary_cta_text',
        'primary_cta_url',
        'secondary_cta_text',
        'secondary_cta_url',
        'hero_section_enabled',
        'about_section_enabled',
        'skills_section_enabled',
        'projects_section_enabled',
        'services_section_enabled',
        'work_process_section_enabled',
        'testimonials_section_enabled',
        'contact_cta_section_enabled',
        'contact_cta_heading',
        'contact_cta_description',
        'section_order',
    ];

    protected $casts = [
        'hero_section_enabled' => 'boolean',
        'about_section_enabled' => 'boolean',
        'skills_section_enabled' => 'boolean',
        'projects_section_enabled' => 'boolean',
        'services_section_enabled' => 'boolean',
        'work_process_section_enabled' => 'boolean',
        'testimonials_section_enabled' => 'boolean',
        'contact_cta_section_enabled' => 'boolean',
        'section_order' => 'array',
    ];

    public static function getInstance(): self
    {
        return self::firstOrCreate([], [
            'hero_heading' => 'Full Stack Web Developer',
            'hero_title' => 'Building Scalable Web Applications',
            'hero_description' => 'I craft clean, efficient, and scalable web applications using modern technologies.',
            'primary_cta_text' => 'Hire Me',
            'primary_cta_url' => '/contact',
            'secondary_cta_text' => 'View My Projects',
            'secondary_cta_url' => '/projects',
            'hero_section_enabled' => true,
            'about_section_enabled' => true,
            'skills_section_enabled' => true,
            'projects_section_enabled' => true,
            'services_section_enabled' => true,
            'work_process_section_enabled' => true,
            'testimonials_section_enabled' => false,
            'contact_cta_section_enabled' => true,
            'contact_cta_heading' => 'Ready to work together?',
            'contact_cta_description' => 'Let\'s discuss your next project. I\'m available for freelance work.',
            'section_order' => json_encode(['hero', 'about', 'skills', 'projects', 'services', 'work_process', 'testimonials', 'contact_cta']),
        ]);
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->hero_image ? asset('storage/'.$this->hero_image) : null;
    }
}
