<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Methods\Query;

class MystartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'hest';

    /**
     * @var array Command Aliases
     */
   // protected $aliases = ['listcommands'];

    /**
     * @var string Command Description
     */
    protected $description = 'Hest command, Get a list of commands';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {

        $this->replyWithChatAction(['action'=> Actions::TYPING]);
        $user = \App\Models\User::find(1);
        $telegram_user = Telegram::getWebhookUpdates()['message'];
        // $text = sprintf('%s: %s' . PHP_EOL, 'Почта пользователя в laravel:', $user->email);
        $text = sprintf('%s: %s' . PHP_EOL, 'Ваш номер чата', $telegram_user['chat']['id']);
        //$text .= sprintf('%s: %s' . PHP_EOL, 'Ваше имя пользователя в телеграм', $telegram_user['from']['username']);
        $keyboard = [
            ['7', '8', '9'],
            ['4', '5', '6'],
            ['1', '2', '3'],
            ['0']
        ];

        $reply_markup = Keyboard::remove([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $response = Telegram::sendMessage([
            'chat_id' => $telegram_user['chat']['id'],
            'text' => 'Hello World',
            'reply_markup' => $reply_markup
        ]);
        $messageId = $response->getMessageId();
       /* $response = Query::answerCallbackQuery([
            'callback_query_id' => $telegram_user['chat']['id'],
            'url' => 'https://totxbot.ru/public/test2'
        ]);*/

        /*$messageId = $response->getMessageId();*/
       /* $telegram_user = Telegram::getWebhookUpdates()['callback_query'];*/
       // Log::info($telegram_user);
        $this->replyWithMessage(compact('text'));
    }
}
