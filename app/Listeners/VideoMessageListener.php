<?php

namespace App\Listeners;

use App\Events\Telegram\VideoMessageEvent;
use App\Jobs\Telegram\SendVideoJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Telegram\Bot\Laravel\Facades\Telegram;

class VideoMessageListener implements ShouldQueue
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
     * @param VideoMessageEvent $event
     * @return void
     */
    public function handle(VideoMessageEvent $event)
    {
        $this->delay = data_get($event, 'data.delay');
        $processing = data_get($event, 'data.processing');
        $message = (new SendVideoJob($event->data))->onQueue($processing);
        dispatch($message)->delay($this->delay);
    }
}
