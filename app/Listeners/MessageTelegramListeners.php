<?php

namespace App\Listeners;

use App\Events\Telegram\messageEvent;
use App\Jobs\Telegram\SendMessageJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Telegram\Bot\Laravel\Facades\Telegram;

class MessageTelegramListeners implements ShouldQueue
{
    /**
     * Время (в секундах) до обработки задания.
     *
     * @var int
     */
    public $delay=0;
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
     * @param messageEvent $event
     * @return void
     */
    public function handle(messageEvent $event)
    {
        $this->delay = data_get($event, 'data.delay');
        $processing = data_get($event, 'data.processing');
        $message = (new SendMessageJob($event->data))->onQueue($processing);
        dispatch($message)->delay($this->delay);
    }
}
