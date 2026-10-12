<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_heading')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('primary_cta_text')->nullable();
            $table->string('primary_cta_url')->nullable();
            $table->string('secondary_cta_text')->nullable();
            $table->string('secondary_cta_url')->nullable();
            $table->boolean('hero_section_enabled')->default(true);
            $table->boolean('about_section_enabled')->default(true);
            $table->boolean('skills_section_enabled')->default(true);
            $table->boolean('projects_section_enabled')->default(true);
            $table->boolean('services_section_enabled')->default(true);
            $table->boolean('work_process_section_enabled')->default(true);
            $table->boolean('testimonials_section_enabled')->default(true);
            $table->boolean('contact_cta_section_enabled')->default(true);
            $table->string('contact_cta_heading')->nullable();
            $table->text('contact_cta_description')->nullable();
            $table->json('section_order')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_settings');
    }
};
