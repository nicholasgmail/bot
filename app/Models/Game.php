<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'salute', 'emoji', 'errors_ms', 'first_train', 'regular_train', 'raid', 'battle', 'field_size', 'pid'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;


    /**
     * Get all of the images that are assigned this step.
     */
    public function images()
    {
        return $this->morphedByMany(Image::class, 'gamegable')->withPivot('transition_model','cell');
    }
    /**
     * The roles that belong to the storyline.
     */
    public function storyline()
    {
        return $this->belongsToMany(Storyline::class);
    }


    /**
     * Get the step of game.
     */
  /*  public function deleteStep()
    {
        $this->hasMany(Step::class)->truncate();
        return $this->hasMany(Step::class);
    }*/
}
