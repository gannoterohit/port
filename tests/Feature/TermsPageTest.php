<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TermsPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_terms_page_returns_successful_response(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);
    }

    public function test_terms_route_is_named_terms(): void
    {
        $response = $this->get(route('terms'));

        $response->assertStatus(200);
    }

    public function test_terms_page_creates_default_page_if_missing(): void
    {
        Page::where('slug', 'terms')->delete();

        $response = $this->get('/terms');

        $response->assertStatus(200);
        $this->assertDatabaseHas('pages', [
            'slug' => 'terms',
            'title' => 'Terms of Service',
        ]);
    }

    public function test_terms_page_shows_seeded_content(): void
    {
        $response = $this->get('/terms');

        $response->assertStatus(200);
        $response->assertSee('Terms of Service');
    }
}
