# Laravel için Medya Yöneticisi

Bu paket, Laravel uygulamalarında medya yönetimi için kullanılabilir.

# Genel Bakış

Bu paket, Laravel projelerinde medya dosyalarını (resim ve video) yönetmek için tasarlanmıştır. İşlevselliği, ilgili modele ´MediaTrait´ sınıfını ekleyerek entegre edilebilir.

´MediaTrait´ sınıfları, model ile medya dosyaları arasında ilişkileri oluştururken aynı zamanda ´MediaHelper´ yardımıyla medya işlemlerini gerçekleştirir. Bu işlemler arasında medya dosyalarını modellerle ilişkilendirme, ekleme, çıkarma ve senkronizasyon bulunmaktadır.

Bir medya dosyası güncellendiğinde veya ilişkili model silindiğinde, veritabanından ilişki otomatik olarak kaldırılır. Ayrıca, medya dosyaları diskten silinir ve ilişkili veriler temizlenir. Bu özellikler, medya yönetimini kolay ve verimli hale getirir.


# Kurulum

1. Paketi Laravel projesine ekleyin:

```php

composer require hcakir/laravel-11-media-manager

```

2. Laravel 5.5 ve sonrası sürümler, paketin Service Provider’ını otomatik olarak tanır. Eğer Laravel 5.5 öncesi bir sürüm kullanıyorsanız, config/app.php dosyasındaki providers array’ine aşağıdaki satırı eklemeniz gerekmektedir:

```php

Hcakir\Laravel11MediaManager\Providers\MediaManagerServiceProvider::class,

```

3. Paketin yapılandırma dosyasını ve migration dosyalarını projenize yayınlayın:

```php

php artisan vendor:publish --provider="Hcakir\\Laravel11MediaManager\\Providers\\MediaManagerServiceProvider"


```
- Bu komut, paketin yapılandırma dosyasını config/ klasörüne ve migration dosyalarını database/migrations/ klasörüne kopyalar.


4. Yayınlanan migration dosyalarını çalıştırın:

```php

php artisan migrate

```
- Bu komut, medya yönetim sistemi için gerekli olan veritabanı tablolarını oluşturur.

5. Storage sembolik bağlantısı oluşturun:

```php

php artisan storage:link

```

6. İlgili modelinize MediaTrait'i ekleyin:

```php

use Hcakir\Laravel11MediaManager\Traits\MediaTrait;

class YourModel extends Model
{
    use MediaTrait;
}

```
#### Artık Laravel 11 Media Manager paketini projenizde kullanmaya başlayabilirsiniz!

# Bağımlılıklar
Bu paket aşağıdaki gereksinimlere sahiptir:

* PHP 8.0 veya üstü
* Laravel 10.0 veya 11.0
* PHPUnit 9.0, 10.0 veya 11.0
* Bu gereksinimler, paketin düzgün çalışabilmesi için gereklidir. Lütfen paketi kullanmadan önce bu gereksinimleri karşıladığınızdan emin olun.


# Kullanım

1. Medya dosyaları ekleme ve ilişkileri oluşturma:

```php

if ($request->hasFile('media')) {
    $productCategory->attachMedia($request->file('media'));
}

```

2. Medya dosyaları güncelleme:

```php

if ($request->hasFile('media')) {
    $productCategory->syncMedia($request->file('media'));
}

```

3. Medya silme ve ilişkileri kaldırma:

```php

$productCategory->detachMedia();
$productCategory->delete();

```

4. controller json ile Medya ekleme ve ilişki oluşturma:

```php

public function deleteMedia(Request $request, $categoryId, $mediaId)
{
    $productCategory = ProductCategory::findOrFail($categoryId);
    $media = $productCategory->media()->findOrFail($mediaId);
    $mediaPaths = [$media->path];
    MediaHelper::deleteMedia($mediaPaths);
    return response()->json(['success' => true]);
}

```

5. ilişkili media dosyalarını gösterme:

```php

public function edit(string $id)
{
$productCategory = ProductCategory::findOrFail($id);
$media = $productCategory->media()->get();
return view('backend.pages.product_category.edit', compact('productCategory', 'media'));
}

```

# Diğer Kullanım şekilleri

´MediaHelper´ sınıfı, medya dosyalarını kaydetmek ve silmek için statik metodlar sağlar.

Örnek kullanım:

```php
use Hcakir\Laravel11MediaManager\Helpers\MediaHelper;

$mediaFiles = request()->file('media');
$mediaIds = MediaHelper::storeMedia($mediaFiles);

```

# Testler

- Paket, işlevselliğini doğrulamak için bir dizi test içerir. Testler, ´MediaTraitTest´ sınıfında bulunabilir.
- Testleri çalıştırmak için ´php artisan test´ artisan komutunu terminale yazınız

# Lisans

- Bu paket MIT lisansı altında lisanslanmıştır. Daha fazla bilgi için ´LICENSE´ dosyasını inceleyebilirsiniz.

# Katkıda Bulunma

- Katkılarınızı bekliyoruz! Lütfen bir hata bulduysanız veya bir özellik önermek istiyorsanız, bir sorun oluşturun veya bir çekme isteği gönderin.
