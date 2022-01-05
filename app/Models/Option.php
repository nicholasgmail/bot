<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $fillable=['priority', 'following', 'expect', 'using_condition', 'delay', 'delay_type','figure', 'button_type'];
    /**
     * Get the parent commentable model (image, message or video).
     */
    public function optiontable()
    {
        return $this->morphTo();
    }
}
