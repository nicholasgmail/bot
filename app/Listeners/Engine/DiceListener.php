<?php

namespace App\Listeners\Engine;

use App\Events\Engine\DiceEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DiceListener
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
     * @param DiceEvent $event
     * @return void
     */
    public function handle(DiceEvent $event)
    {
        $name = data_get($event, "data.name");
        if (Str::of($name)->lower()->is('*день х*')) {
            $btn = "▪ День Х";
        }elseif (Str::of($name)->lower()->is('*благотворительность*')
            || Str::of($name)->lower()->is('*потеря*')
            || Str::of($name)->lower()->is('*беременность*')) {
            $btn = "▪ Взять сюжет";
        } else {
            $btn = "▪ Взять " . $name;
        }
        
        return Arr::wrap(['name' => $btn]);
    }
}
