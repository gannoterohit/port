<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const LOCAL_WEBSITE_URL = 'http://192.168.29.83:7000';

    private const SEEDED_TESTIMONIALS = [
        [
            'name' => 'Vikas Sharma',
            'role_company' => 'Founder & CEO, RetailPulse Solutions',
            'feedback' => 'Rohit delivered our e-commerce platform ahead of schedule with immaculate code quality. His mastery in Laravel and MySQL solved database bottlenecks that our previous developers struggled with for months. Highly recommended!',
        ],
        [
            'name' => 'Amit Patel',
            'role_company' => 'Product Director, TechVentures India',
            'feedback' => 'Outstanding communication and sheer technical depth. Rohit transformed our raw business requirements into a polished, responsive SaaS dashboard. The API speed and UI responsiveness are top-tier.',
        ],
        [
            'name' => 'Neha Deshmukh',
            'role_company' => 'Operations Lead, CloudLogistics Hub',
            'feedback' => 'Working with Rohit has been seamless. From initial architectural planning to final deployment, he demonstrated true professionalism, clean coding conventions, and rock-solid reliability.',
        ],
    ];

    public function up(): void
    {
        foreach (self::SEEDED_TESTIMONIALS as $testimonial) {
            DB::table('testimonials')
                ->where($testimonial)
                ->update(['is_published' => false]);
        }

        $profile = DB::table('profiles')->select('id', 'social_links')->first();

        if (! $profile || ! $profile->social_links) {
            return;
        }

        $socialLinks = json_decode($profile->social_links, true);

        if (($socialLinks['website'] ?? null) !== self::LOCAL_WEBSITE_URL) {
            return;
        }

        unset($socialLinks['website']);

        DB::table('profiles')
            ->where('id', $profile->id)
            ->update(['social_links' => json_encode($socialLinks)]);
    }

    public function down(): void
    {
        foreach (self::SEEDED_TESTIMONIALS as $testimonial) {
            DB::table('testimonials')
                ->where($testimonial)
                ->update(['is_published' => true]);
        }

        $profile = DB::table('profiles')->select('id', 'social_links')->first();

        if (! $profile || ! $profile->social_links) {
            return;
        }

        $socialLinks = json_decode($profile->social_links, true);

        if (isset($socialLinks['website'])) {
            return;
        }

        $socialLinks['website'] = self::LOCAL_WEBSITE_URL;

        DB::table('profiles')
            ->where('id', $profile->id)
            ->update(['social_links' => json_encode($socialLinks)]);
    }
};
