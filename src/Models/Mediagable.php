<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediagable extends Model
{
    use HasFactory;
    protected $fillable = ['media_id', 'mediagable_id', 'mediagable_type'];

    public function media()
    {
        return $this->morphTo();
    }
}
