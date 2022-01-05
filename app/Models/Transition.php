<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transition extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'storylinegable_type', 'storylinegable_id', 'weight', 'btn_random'];
    
    /**
     * Get the parent commentable model (image, message or video).
     */
    public function transitiontable()
    {
        return $this->morphTo();
    }

}
