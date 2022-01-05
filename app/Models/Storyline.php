<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storyline extends Model
{
    //сценарий
    use HasFactory;

    protected $fillable = ['name', 'hide', 'train', 'hash', 'level', 'balance', 'put_where', 'purpose_plot', 'purpose_plot', 'show_level', 'game_type', 'complexity', 'plot_lists', 'show_level', 'point_a'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Get the Image of storyline.
     */
    public function messages()
    {
        return $this->morphedByMany(Message::class, 'storylinegable');
    }

    /**
     * Get the Image of storyline.
     */
    public function images()
    {
        return $this->morphedByMany(Image::class, 'storylinegable');
    }

    /**
     * Get the Image of storyline.
     */
    public function videos()
    {
        return $this->morphedByMany(Video::class, 'storylinegable');
    }

    /**
     * Get the Image of storyline.
     */
    public function categories()
    {
        return $this->morphedByMany(Category::class, 'storylinegable');
    }


    /**
     * Get the step of game.
     */
    public function deleteStoryline()
    {
        $this->hasMany(Message::class)->delete();
        return $this->hasMany(Message::class);
    }

    /**
     * The roles that belong to the storyline.
     */
    public function game()
    {
        return $this->belongsToMany(Game::class)->withPivot('id');
    }
}
