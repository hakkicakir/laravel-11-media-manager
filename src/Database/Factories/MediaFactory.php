<?php

namespace Hcakir\Laravel11MediaManager\Database\Factories;

use Hcakir\Laravel11MediaManager\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition()
    {
        return [
            'path' => 'media/test.jpg',
            'is_video' => false, // Varsayılan olarak false olarak ayarladık
            // Diğer alanlarınızı burada tanımlayabilirsiniz...
        ];
    }
}
