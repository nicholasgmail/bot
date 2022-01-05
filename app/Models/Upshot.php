<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upshot extends Model
{
    use HasFactory;

    protected $fillable = ['color', 'nick', 'balance', 'day_x', 'purpose', 'response_wait', 'train', 'months', 'complexity', 'purchase', 'rival', 'level', 'list_storyline', 'months_count', 'game_count', 'client', 'history', 'briefcase', 'step_number', 'step_map'];

    public function upshotable()
    {
        return $this->morphTo();
    }
}
