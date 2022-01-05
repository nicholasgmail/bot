<?php

namespace App\Listeners;

use App\Events\Telegram\PhotoMessageEvent;
use App\Jobs\Telegram\SendPhotoJob;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PhotoMessageListener implements ShouldQueue
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
     * @param  PhotoMessageEvent  $event
     * @return void
     */
    public function handle(PhotoMessageEvent $event)
    {
        $this->delay = data_get($event, 'data.delay');
        $processing = data_get($event, 'data.processing');
        $message = (new SendPhotoJob($event->data))->onQueue($processing);
        dispatch($message)->delay($this->delay);
    }
}
