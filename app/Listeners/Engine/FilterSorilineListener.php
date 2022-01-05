<?php

namespace App\Listeners\Engine;

use App\Events\Engine\FilterSorilineEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FilterSorilineListener
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
     * @param FilterSorilineEvent $event
     * @return void
     */
    public function handle(FilterSorilineEvent $event)
    {
        $st_line = data_get($event, "data.cat_filter.storyline");
        $st_line = collect($st_line)->filter(function ($value, $key) {
            $train = json_decode(data_get($value, 'train'));
            return is_null($train) ? true : collect($train)->contains($this->data_dialog->upshot->train);
        });
        $st_line = $st_line->filter(function ($value, $key) {
            $level = json_decode(data_get($value, 'level'));
            return is_null($level) ? true : collect($level)->contains($this->data_dialog->upshot->level);
        });
        $st_line = $st_line->filter(function ($value, $key) {
            $game_type = json_decode(data_get($value, 'game_type'));
            return is_null($game_type) ? true : collect($game_type)->contains($this->data_dialog->upshot->purpose);
        });
        $st_line = $st_line->filter(function ($value, $key) {
            $arr = collect(json_decode(data_get($value, 'plot_lists')));
            $exclude = data_get($arr, 'exclude');
            return is_null($exclude) ? true : !Str::contains($exclude, data_get($value, 'id'));
        });
        $st_line = $st_line->filter(function ($value, $key) {
            $arr = collect(json_decode(data_get($value, 'plot_lists')));
            $show = data_get($arr, 'show');
            return is_null($show) ? true : Str::contains($show, data_get($value, 'id'));
        });
        $st_line = $st_line->filter(function ($value, $key) {
            $arr = collect(json_decode(data_get($value, 'plot_lists')));
            $name = data_get($arr, 'name');
            return is_null($name) ? true : Str::contains($name, data_get($value, 'name'));
        });
        $st_line = $st_line->filter(function ($value, $key) {
            $arr = collect(json_decode(data_get($value, 'plot_lists')));
            $from_what = data_get($arr, 'from_what');
            return is_null($from_what) ? true : (integer)$from_what >= data_get($value, 'id');
        });
        $st_line = $st_line->filter(function ($value, $key) {
            $arr = collect(json_decode(data_get($value, 'plot_lists')));
            $up_to_what = data_get($arr, 'up_to_what');
            return is_null($up_to_what) ? true : (integer)$up_to_what <= data_get($value, 'id');
        });
        return $st_line;
    }
}
