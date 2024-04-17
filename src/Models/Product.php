<?php

namespace Hcakir\Laravel11MediaManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Hcakir\Laravel11MediaManager\Traits\MediaTrait;
use Hcakir\Laravel11MediaManager\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory, MediaTrait;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the media for the product.
     */
    public function media()
    {
        return $this->morphToMany(\Hcakir\Laravel11MediaManager\Models\Media::class, 'mediagable');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ProductFactory::new();
    }
}
