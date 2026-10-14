<?php

namespace Tests\Feature;

use App\Models\HomepageSetting;
use App\Models\Page;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Traits\HandlesFileUploads;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageOptimizationTest extends TestCase
{
    use HandlesFileUploads;

    public function test_is_image_detects_image_files(): void
    {
        $file = UploadedFile::fake()->image('test.jpg');

        $this->assertTrue($this->isImage($file));
    }

    public function test_is_image_returns_false_for_non_images(): void
    {
        $file = UploadedFile::fake()->create('document.txt', 100, 'text/plain');

        $this->assertFalse($this->isImage($file));
    }

    public function test_upload_file_optimizes_images_to_webp(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('test.jpg', 2400, 1600);

        $path = $this->uploadFile($file, 'test-dir');

        $this->assertStringEndsWith('.webp', $path);
        $this->assertStringContainsString('test-dir', $path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_public_storage_urls_use_the_asset_base_url(): void
    {
        $assetBaseUrl = rtrim(config('app.asset_url') ?: config('app.url'), '/');
        $profile = new Profile(['profile_photo' => 'profile/avatar.jpg']);

        $this->assertSame(
            $assetBaseUrl.'/storage/profile/avatar.jpg',
            Storage::disk('public')->url('profile/avatar.jpg')
        );
        $this->assertSame($assetBaseUrl.'/storage/profile/avatar.jpg', $profile->profile_photo_url);
    }

    public function test_model_media_urls_use_the_public_storage_disk(): void
    {
        $assetBaseUrl = rtrim(config('app.asset_url') ?: config('app.url'), '/').'/storage';
        $project = new Project(['thumbnail' => 'projects/thumbnail.webp', 'og_image' => 'projects/social.webp']);
        $service = new Service(['icon' => 'services/icon.webp', 'image' => 'services/image.webp']);
        $page = new Page(['og_image' => 'pages/social.webp']);
        $homepage = new HomepageSetting(['hero_image' => 'homepage/hero.webp']);

        $this->assertSame($assetBaseUrl.'/projects/thumbnail.webp', $project->thumbnail_url);
        $this->assertSame($assetBaseUrl.'/projects/social.webp', $project->og_image_url);
        $this->assertSame($assetBaseUrl.'/services/icon.webp', $service->icon_url);
        $this->assertSame($assetBaseUrl.'/services/image.webp', $service->image_url);
        $this->assertSame($assetBaseUrl.'/pages/social.webp', $page->og_image_url);
        $this->assertSame($assetBaseUrl.'/homepage/hero.webp', $homepage->hero_image_url);
    }

    public function test_store_optimized_image_resizes_large_images(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('large.png', 3000, 2000);

        $path = $this->storeOptimizedImage($file, 'test-dir', maxWidth: 1920);

        $this->assertStringEndsWith('.webp', $path);
        Storage::disk('public')->assertExists($path);

        $imageContent = Storage::disk('public')->get($path);
        $image = imagecreatefromstring($imageContent);

        $this->assertLessThanOrEqual(1920, imagesx($image));
    }

    public function test_upload_file_passes_through_non_image_files(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('document.pdf', 100);

        $path = $this->uploadFile($file, 'test-dir');

        $this->assertStringEndsWith('.pdf', $path);
        $this->assertStringNotContainsString('.webp', $path);
    }
}
