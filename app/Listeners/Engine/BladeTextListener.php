<?php

namespace App\Listeners\Engine;

use App\Events\Engine\BladeTextEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BladeTextListener
{
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
     * @param  BladeTextEvent  $event
     * @return void
     */
    public function handle(BladeTextEvent $event)
    {
        //
    }
}
