<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'url', 'caption'];

    /**
     * Get all of the step for the image.
     */
    public function game()
    {
        return $this->morphToMany(Game::class, 'gamegable')->withPivot('transition_model','cell');
    }
    /**
     * Get all of the step for the image.
     */
    public function cube()
    {
        return $this->morphToMany(Cube::class, 'cubegable');
    }

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
