<?php

namespace App\Listeners\Recruiting;

use App\Events\Recruiting\BriefcaseSorilineEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BriefcaseSorilineListener
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
     * @param  BriefcaseSorilineEvent  $event
     * @return void
     */
    public function handle(BriefcaseSorilineEvent $event)
    {
        $storyline = data_get($event, 'storyline');
        $upshot = data_get($event, 'upshot');
        $caregory = Str::of($storyline->categories->first()->name)->lower()->is('день х');

        if(is_null($caregory)){
            return false;
        }
        $briefcase = collect(json_decode($upshot->briefcase))->toArray();
        return $briefcase;
    }
}
