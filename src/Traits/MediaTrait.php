<?php

namespace Hcakir\Laravel11MediaManager\Traits;

use Hcakir\Laravel11MediaManager\Helpers\MediaHelper;
use Hcakir\Laravel11MediaManager\Models\Media;

trait MediaTrait
{
    protected static function bootMediaTrait()
    {
        static::addGlobalScope('media', function ($query) {
            $query->with('media');
        });
    }

    public function media()
    {
        return $this->morphToMany(Media::class, 'mediagable');
    }

    public function attachMedia(array $mediaFiles)
    {
        $mediaIds = MediaHelper::storeMedia($mediaFiles);
        $this->media()->syncWithoutDetaching($mediaIds);
    }

    public function detachMedia()
    {
        $mediaItems = $this->media;
        $mediaPaths = $mediaItems->pluck('path')->toArray();
        MediaHelper::deleteMedia($mediaPaths);
        // Şimdi ilişkili medya kayıtlarını silelim
        $this->media()->delete(); // Eloquent ilişki üzerinden silme işlemi
    }

    public function syncMedia(array $mediaFiles)
    {
        // Disk üzerindeki mevcut medya dosyalarının listesini alın
        $currentMediaPaths = $this->media->pluck('path')->toArray();

        // Modelden kaldırılacak olan medya dosyalarını bulun
        $mediaToRemove = array_diff($currentMediaPaths, $mediaFiles);

        // Modelden kaldırılacak olan medya dosyalarını disk üzerinden silin
        MediaHelper::deleteMedia($mediaToRemove);

        // Modele eklenecek olan medya dosyalarını disk üzerine yükleyin
        $mediaIdsToAdd = MediaHelper::storeMedia($mediaFiles);

        // Medya dosyalarını senkronize edin
        $mediaIds = array_merge(MediaHelper::getMediaIds($currentMediaPaths), $mediaIdsToAdd);
        $this->media()->sync($mediaIds);
    }

    public function hasMedia(string $mediaPath)
    {
        return $this->media->contains('path', $mediaPath);
    }
}
