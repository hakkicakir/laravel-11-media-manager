<?php

namespace Hcakir\Laravel11MediaManager\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Hcakir\Laravel11MediaManager\Models\Media;

class MediaHelper
{
    private static $disk = 'public';

    public static function storeMedia(array $mediaFiles): array
    {
        $mediaIds = [];
        foreach ($mediaFiles as $file) {
            $uniqueName = self::generateUniqueFileName($file);
            $storedPath = self::storeFile($file, $uniqueName);

            if ($storedPath) {
                $media = self::saveMediaRecord($storedPath, self::isVideo($file));
                $mediaIds[] = $media->id;
            }
        }
        return $mediaIds;
    }

    public static function deleteMedia(array $mediaPaths): void
    {
        foreach ($mediaPaths as $mediaPath) {
            $fullPath = Storage::disk(self::$disk)->path('media/' . basename($mediaPath));
            // Dosyayı diskten sil
            if (file_exists($fullPath)) {
                unlink($fullPath);
            } else {
                Log::error("Unable to delete file: {$fullPath}");
            }
        }
    }

    public static function getMediaIds(array $mediaPaths): array
    {
        return Media::whereIn('path', $mediaPaths)->pluck('id')->toArray();
    }

    public static function generateUniqueFileName($mediaFile): string
    {
        return Str::random(20) . '.' . $mediaFile->getClientOriginalExtension();
    }

    protected static function isVideo($mediaFile): bool
    {
        $extension = $mediaFile->getClientOriginalExtension();
        return in_array($extension, ['webm', 'mp4']);
    }

    private static function storeFile($mediaFile, $fileName): ?string
    {
        $path = Storage::disk(self::$disk)->putFileAs('media', $mediaFile, $fileName);
        return $path ? '/media/' . basename($path) : null;
    }

    private static function saveMediaRecord(string $path, bool $isVideo): Media
    {
        $media = new Media();
        $media->path = $path;
        $media->is_video = $isVideo;
        $media->save();
        return $media;
    }
}
