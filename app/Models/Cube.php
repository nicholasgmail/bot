<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cube extends Model
{
    use HasFactory;
      protected $fillable = ['title', 'salute', 'active'];

    /**
     * Get the Image of storyline.
     */
    public function images()
    {
        return $this->morphedByMany(Image::class, 'cubegable');
    }
}
