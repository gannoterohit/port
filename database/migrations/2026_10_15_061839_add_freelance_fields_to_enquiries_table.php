<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->string('project_type', 100)->nullable()->after('subject');
            $table->string('budget_range', 100)->nullable()->after('project_type');
            $table->string('timeline', 100)->nullable()->after('budget_range');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropColumn(['project_type', 'budget_range', 'timeline']);
        });
    }
};
