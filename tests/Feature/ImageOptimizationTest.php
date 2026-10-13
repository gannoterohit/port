<?php

namespace Tests\Feature;

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
