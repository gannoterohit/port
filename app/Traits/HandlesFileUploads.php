<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesFileUploads
{
    protected function uploadFile(?UploadedFile $file, string $directory, ?string $oldFile = null): ?string
    {
        if (! $file) {
            return $oldFile;
        }

        if ($oldFile) {
            Storage::disk('public')->delete($oldFile);
        }

        if ($this->isImage($file)) {
            return $this->storeOptimizedImage($file, $directory);
        }

        return $file->store($directory, 'public');
    }

    protected function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function generateUniqueFilename(string $originalName): string
    {
        return Str::uuid().'.'.$originalName;
    }

    protected function isImage(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType(), 'image/');
    }

    protected function storeOptimizedImage(UploadedFile $file, string $directory, int $maxWidth = 1920, int $quality = 82): string
    {
        $image = imagecreatefromstring($file->get());

        if (! $image) {
            return $file->store($directory, 'public');
        }

        $originalWidth = imagesx($image);
        $originalHeight = imagesy($image);

        if ($originalWidth > $maxWidth) {
            $ratio = $maxWidth / $originalWidth;
            $newHeight = (int) round($originalHeight * $ratio);
            $resized = imagecreatetruecolor($maxWidth, $newHeight);
            if ($file->getClientMimeType() === 'image/png') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
                imagefilledrectangle($resized, 0, 0, $maxWidth, $newHeight, $transparent);
            }
            imagecopyresampled($resized, $image, 0, 0, 0, 0, $maxWidth, $newHeight, $originalWidth, $originalHeight);
            imagedestroy($image);
            $image = $resized;
        }

        $filename = $directory.'/'.Str::uuid().'.webp';
        $tempFile = tempnam(sys_get_temp_dir(), 'img_opt_');

        imagewebp($image, $tempFile, $quality);
        imagedestroy($image);

        if (! Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }

        $stream = fopen($tempFile, 'r+');
        Storage::disk('public')->writeStream($filename, $stream);
        fclose($stream);
        unlink($tempFile);

        return $filename;
    }
}
