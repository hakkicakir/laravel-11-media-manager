<?php

namespace Tests\Unit;

use Tests\TestCase;
use Hcakir\Laravel11MediaManager\Models\Product;
use Hcakir\Laravel11MediaManager\Models\Media;
use Hcakir\Laravel11MediaManager\Traits\MediaTrait;
use Hcakir\Laravel11MediaManager\Helpers\MediaHelper;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaTraitTest extends TestCase
{
    use MediaTrait, WithFaker, RefreshDatabase;

    protected $product;
    protected $mediaFiles;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = Product::factory()->create(['name' => 'Test Product']);
        $this->mediaFiles = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg'),
        ];
    }

    protected function tearDown(): void
    {
        // Medya dosyalarını diskten silin
        Storage::disk('public')->deleteDirectory('media');

        parent::tearDown();
    }

    public function testMediaRelation()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphToMany::class, $this->product->media());
    }

    public function testAttachMedia()
    {
        $this->product->attachMedia($this->mediaFiles);

        $this->assertCount(2, $this->product->media);
    }

    public function testDetachMedia()
    {
        $this->product->attachMedia($this->mediaFiles);

        // Detach işlemi
        $this->product->detachMedia();

        // Medya dosyalarının gerçekten silinip silinmediğini kontrol etme
        foreach ($this->mediaFiles as $mediaFile) {
            $fullPath = storage_path('app/public/media/' . $mediaFile->getClientOriginalName());
            $this->assertFileDoesNotExist($fullPath);
        }

        // Veritabanından medya kayıtlarının silinmesini yansıtmak için $product nesnesini yeniden yükleyin
        $this->product->load('media');

        // Detach işleminin başarılı bir şekilde gerçekleştiğini doğrulama
        $this->assertCount(0, $this->product->media);
    }

    public function testSyncMedia()
    {
        $this->product->attachMedia($this->mediaFiles);
        $newMediaFiles = [
            UploadedFile::fake()->image('photo3.jpg'),
            UploadedFile::fake()->image('photo4.jpg'),
        ];

        $this->product->syncMedia($newMediaFiles);

        $this->assertCount(2, $this->product->media);
    }

    public function testHasMedia()
{
    // Veritabanında bir medya dosyası oluşturun
    $media = Media::factory()->create();

    // Medya dosyasını bir modele ilişkilendirin
    $this->product->media()->attach($media->id);

    // hasMedia fonksiyonunu test edin
    $this->assertTrue($this->product->hasMedia($media->path));
    $this->assertFalse($this->product->hasMedia('media/nonexistent.jpg'));
}
}
