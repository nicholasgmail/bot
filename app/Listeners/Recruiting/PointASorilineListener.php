<?php

namespace App\Listeners\Recruiting;

use App\Events\Recruiting\PointASorilineEvent;
use App\Models\Category;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PointASorilineListener
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
     * @param  PointASorilineEvent  $event
     * @return void
     */
    public function handle(PointASorilineEvent $event)
    {
        $storyline = data_get($event, 'storyline');
        $upshot = data_get($event, 'upshot');
        $caregory = Str::of($storyline->categories->first()->name)->lower()->is('точка а');
        if(!$caregory){
            return false;
        }
        $upshot->update(['briefcase'=>$storyline->point_a]);
        $upshot->update(['balance'=>data_get(json_decode($storyline->point_a), 'balance_a')]);

        $point_a = collect(json_decode($storyline->point_a))->toArray();
        return $point_a;
    }
}
