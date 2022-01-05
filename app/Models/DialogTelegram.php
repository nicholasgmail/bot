<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DialogTelegram extends Model
{
    use HasFactory;
    public $fillable = ['storyline_id', 'from_id', 'chat_id', 'newcomer', 'create_nick', 'dialog_id', 'dialog_type', 'game_id', 'dice_roll', 'will_stop', 'shown', 'take_it'];

    /**
     * Get the dialog telegram upshots.
     */
    public function upshot()
    {
        return $this->morphOne(Upshot::class, 'upshotable');
    }
    
}
