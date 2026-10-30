<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\VisitorLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorTrackingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_visitor_middleware_logs_public_page_visit(): void
    {
        $response = $this->withServerVariables([
            'REMOTE_ADDR' => '103.21.244.2',
            'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36',
            'HTTP_REFERER' => 'https://www.linkedin.com/feed/',
        ])->get('/');

        $response->assertStatus(200);

        $this->assertDatabaseHas('visitor_logs', [
            'ip_address' => '103.21.244.2',
            'device_type' => 'Desktop',
            'referer_host' => 'LinkedIn',
        ]);
    }

    public function test_admin_can_view_visitor_analytics_dashboard(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        $response = $this->actingAs($admin)->get(route('admin.analytics.index'));

        $response->assertStatus(200);
        $response->assertSee('Visitor Traffic &amp; Page Activity', false);
    }

    public function test_admin_can_save_seo_and_analytics_keys(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        $response = $this->actingAs($admin)->put(route('admin.seo.update'), [
            'meta_title' => 'My Portfolio',
            'meta_description' => 'Developer Portfolio',
            'google_analytics_id' => 'G-ABC123XYZ',
            'google_search_console_code' => 'gsc-verification-code-sample',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertEquals('G-ABC123XYZ', \App\Models\Setting::get('google_analytics_id'));
        $this->assertEquals('gsc-verification-code-sample', \App\Models\Setting::get('google_search_console_code'));
    }
}
