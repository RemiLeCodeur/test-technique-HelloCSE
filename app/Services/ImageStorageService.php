<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/** Gestion centralisée des fichiers images (upload, remplacement, suppression). */
class ImageStorageService
{
    /** Disque exposé publiquement via `storage:link`. */
    public const DISK = 'public';

    public function store(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, self::DISK);
    }

    /** Stocke la nouvelle image puis supprime l'ancienne. */
    public function replace(UploadedFile $file, string $directory, ?string $previousPath): string
    {
        $newPath = $this->store($file, $directory);
        $this->delete($previousPath);

        return $newPath;
    }

    public function delete(?string $path): void
    {
        if ($path !== null && Storage::disk(self::DISK)->exists($path)) {
            Storage::disk(self::DISK)->delete($path);
        }
    }

    public function url(?string $path): ?string
    {
        return $path === null ? null : Storage::disk(self::DISK)->url($path);
    }
}
