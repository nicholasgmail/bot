<?php

namespace App\Listeners\Engine;

use App\Events\Engine\PadSorilineEvent;
use App\Traits\HelpersBotCommands;
use App\Traits\MessageCollect;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class PadSorilineListener
{
    use MessageCollect, HelpersBotCommands;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PadSorilineEvent $event
     * @return void
     */
    public function handle(PadSorilineEvent $event)
    {
        $messages = data_get($event, 'messages');
        $dialog = data_get($event, 'dialog');
        $messag_pad = $messages->first(function ($value, $key) {
            return data_get($value, "option.pad");
        });
        $option_delay = data_get($messag_pad, 'option.delay');
        $text_slice = data_get($messag_pad, 'caption');;
        $delay_slice = $this->delayType(data_get($messag_pad, 'option.delay_type'), $option_delay);
        $uri_slice = data_get($messag_pad, 'url');
        $type_slice = class_basename(data_get($messag_pad, 'option.optiontable_type'));
        $text_slice = $this->getCaption(null, $dialog->id, $text_slice);
        $keyboard = $this->getKeyboard($messag_pad);
        $reply_markup = $this->getReplyMarkup($keyboard, 'reply');
        $this->pushMessage($dialog->chat_id, $text_slice, $reply_markup, $delay_slice, $allow_sending_without_reply = true, $uri_slice, $type_slice, 'last', $will_stop=1);
        $dialog->update([
            'storyline_id' => data_get($messag_pad, 'pivot.storyline_id'),
            'dialog_id' => data_get($messag_pad, 'pivot.storylinegable_id'),
            "dialog_type" => class_basename(data_get($messag_pad, 'pivot.storylinegable_type'))
        ]);
        exit;
    }
}
