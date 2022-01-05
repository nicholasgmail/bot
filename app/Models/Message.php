<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'caption'];

    /**
     * Get all of the step for the message.
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
