<?php

namespace Hcakir\Laravel11MediaManager\Database\Factories;

use Hcakir\Laravel11MediaManager\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            
        ];
    }
}
