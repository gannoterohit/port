<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('intro')->nullable();
            $table->longText('biography')->nullable();
            $table->longText('experience_text')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('resume_pdf')->nullable();
            $table->boolean('resume_button_visible')->default(true);
            $table->string('location')->nullable();
            $table->boolean('location_visible')->default(false);
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->json('social_links')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
