<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('visitor_logs')) {
            Schema::create('visitor_logs', function (Blueprint $table) {
                $table->id();
                $table->string('ip_address', 45);
                $table->string('page_url', 500);
                $table->string('page_title', 255)->nullable();
                $table->string('route_name', 100)->nullable();
                $table->string('method', 10)->default('GET');
                $table->text('referer')->nullable();
                $table->string('referer_host', 150)->nullable()->default('Direct');
                $table->string('device_type', 30)->default('Desktop');
                $table->string('browser', 50)->nullable();
                $table->string('os', 50)->nullable();
                $table->string('country', 100)->nullable();
                $table->string('city', 100)->nullable();
                $table->text('user_agent')->nullable();
                $table->string('session_id', 100)->nullable();
                $table->boolean('is_bot')->default(false);
                $table->timestamps();

                $table->index('created_at');
                $table->index('ip_address');
                $table->index('device_type');
                $table->index('referer_host');
                $table->index('is_bot');
            });
        }

        // Insert new SEO & Analytics settings if not present
        $newSettings = [
            [
                'group' => 'seo',
                'key' => 'google_analytics_id',
                'value' => null,
                'type' => 'text',
                'label' => 'Google Analytics GA4 ID',
                'description' => 'Measurement ID starting with G- (e.g. G-XXXXXXXXXX)',
                'is_active' => true,
                'sort_order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'seo',
                'key' => 'google_search_console_code',
                'value' => null,
                'type' => 'text',
                'label' => 'Google Search Console Verification',
                'description' => 'HTML tag verification content or verification key',
                'is_active' => true,
                'sort_order' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'seo',
                'key' => 'custom_head_scripts',
                'value' => null,
                'type' => 'textarea',
                'label' => 'Custom Header Scripts (<head>)',
                'description' => 'Custom tracking tags, meta pixels, or head scripts',
                'is_active' => true,
                'sort_order' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'seo',
                'key' => 'custom_body_scripts',
                'value' => null,
                'type' => 'textarea',
                'label' => 'Custom Footer Scripts (</body>)',
                'description' => 'Custom JavaScript or chat widgets to inject before </body>',
                'is_active' => true,
                'sort_order' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($newSettings as $setting) {
            $exists = DB::table('settings')->where('key', $setting['key'])->exists();
            if (!$exists) {
                DB::table('settings')->insert($setting);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');

        DB::table('settings')->whereIn('key', [
            'google_analytics_id',
            'google_search_console_code',
            'custom_head_scripts',
            'custom_body_scripts',
        ])->delete();
    }
};
