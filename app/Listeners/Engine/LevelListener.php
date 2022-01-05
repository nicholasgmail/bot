<?php

namespace App\Listeners\Engine;

use App\Events\Engine\LevelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class LevelListener
{
    /**
     * Create a new component instance.
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
     * @param LevelEvent $event
     * @return void
     */
    public function handle(LevelEvent $event)
    {
        $balance = data_get($event, "data.balance");
       // $lv = ['0 - 24999', '25000 - 99999', '100000 - 499999', '500000 - 9999999', '1000000 - 1999999', '2000000 - 4999999', '5000000'];
        if ($balance >= 0 && $balance <= 24999) {
            $lv = 'lv_1';
        } elseif ($balance >= 25000 && $balance <= 99999) {
            $lv = 'lv_2';
        } elseif ($balance >= 100000 && $balance <= 299999) {
            $lv = 'lv_3';
        } elseif ($balance >= 300000 && $balance <= 499999) {
            $lv = 'lv_4';
        } elseif ($balance >= 500000 && $balance <= 999999) {
            $lv = 'lv_5';
        } elseif ($balance >= 1000000 && $balance <= 2999999) {
            $lv = 'lv_6';
        } else {
            $lv = 'lv_7';
        }
        return Arr::wrap(['level' => $lv]);
    }
}
