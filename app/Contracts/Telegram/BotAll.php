<?php

namespace App\Contracts\Telegram;

interface BotAll
{
    public function sendMessageFollowing($id, $slices, $dialog);

    public function exceptMessage($id, $text);

}
