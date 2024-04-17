<?php

namespace Hcakir\Laravel11MediaManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hcakir\Laravel11MediaManager\Database\Factories\MediaFactory;

class Media extends Model
{
    use HasFactory;

    protected $table = 'medias';
    protected $fillable = ['path', 'is_video'];

    public function mediagable()
    {
        return $this->morphMany(\Hcakir\Laravel11MediaManager\Models\Mediagable::class, 'media');
    }

    protected static function newFactory()
    {
        return MediaFactory::new();
    }
}
