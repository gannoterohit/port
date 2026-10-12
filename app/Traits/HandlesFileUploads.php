<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesFileUploads
{
    protected function uploadFile(?\Illuminate\Http\UploadedFile $file, string $directory, ?string $oldFile = null): ?string
    {
        if (!$file) {
            return $oldFile;
        }

        if ($oldFile) {
            Storage::disk('public')->delete($oldFile);
        }

        $path = $file->store($directory, 'public');

        return $path;
    }

    protected function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function generateUniqueFilename(string $originalName): string
    {
        return Str::uuid() . '.' . $originalName;
    }
}
