<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable= ['name', 'cell_number'];

    /**
     * Get all of the messages for the steps.
     */
    public function storyline()
    {
        return $this->morphToMany(Storyline::class, 'storylinegable');
    }

}
