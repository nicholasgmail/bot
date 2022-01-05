<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'url', 'caption'];

    /**
     * Get all of the messages for the steps.
     */
    public function storyline()
    {
        return $this->morphToMany(Storyline::class, 'storylinegable');
    }
    /**
     * Get all of the images transition.
     */
    public function option()
    {
        return $this->morphOne(Option::class, 'optiontable');
    }
    /**
     * Get all of the images transition.
     */
    public function transitions()
    {
        return $this->morphMany(Transition::class, 'transitiontable');
    }
}
