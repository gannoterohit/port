<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->actingAs(User::where('email', 'admin@example.com')->first());
    }

    public function test_project_model_has_client_name_in_fillable(): void
    {
        $project = new Project;

        $this->assertContains('client_name', $project->getFillable());
    }

    public function test_project_can_be_created_with_client_name(): void
    {
        $project = Project::create([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'category' => 'Web Application',
            'client_name' => 'Acme Corp',
            'description' => 'A test project description.',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
            'display_order' => 1,
        ]);

        $this->assertDatabaseHas('projects', [
            'title' => 'Test Project',
            'slug' => 'test-project',
            'client_name' => 'Acme Corp',
            'category' => 'Web Application',
        ]);
    }

    public function test_project_can_be_updated_with_client_name(): void
    {
        $project = Project::create([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'category' => 'Web Application',
            'client_name' => null,
            'description' => 'A test project description.',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
            'display_order' => 1,
        ]);

        $project->update(['client_name' => 'Updated Client']);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'client_name' => 'Updated Client',
        ]);
    }

    public function test_project_store_requires_title(): void
    {
        $response = $this->post(route('admin.projects.store'), [
            'slug' => 'test-project',
            'status' => 'published',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_project_store_validates_client_name_max_length(): void
    {
        $response = $this->post(route('admin.projects.store'), [
            'title' => 'Test Project',
            'status' => 'published',
            'client_name' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('client_name');
    }

    public function test_project_show_page_displays_client_name(): void
    {
        $initialLevel = ob_get_level();

        Project::create([
            'title' => 'Test Project',
            'slug' => 'test-project',
            'category' => 'Web Application',
            'client_name' => 'Acme Corp',
            'description' => 'A test project description.',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
            'display_order' => 1,
        ]);

        $response = $this->get(route('projects.show', 'test-project'));

        $response->assertStatus(200);
        $response->assertSee('Acme Corp');

        while (ob_get_level() > $initialLevel) {
            ob_end_clean();
        }
    }
}
