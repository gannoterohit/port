<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->index(['status', 'published_at', 'display_order'], 'projects_status_pub_order_idx');
            $table->index(['is_featured', 'status', 'published_at'], 'projects_featured_status_idx');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->index(['is_enabled', 'is_featured', 'display_order'], 'skills_enabled_featured_order_idx');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index(['is_enabled', 'is_featured', 'display_order'], 'services_enabled_featured_order_idx');
        });

        Schema::table('enquiries', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'enquiries_status_created_idx');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('projects_status_pub_order_idx');
            $table->dropIndex('projects_featured_status_idx');
        });

        Schema::table('skills', function (Blueprint $table) {
            $table->dropIndex('skills_enabled_featured_order_idx');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex('services_enabled_featured_order_idx');
        });

        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropIndex('enquiries_status_created_idx');
        });
    }
};
