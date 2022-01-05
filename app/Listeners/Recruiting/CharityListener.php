<?php

namespace App\Listeners\Recruiting;

use App\Events\Recruiting\CharityEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CharityListener
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
     * @param CharityEvent $event
     * @return void
     */
    public function handle(CharityEvent $event)
    {
        $storyline = data_get($event, 'storyline');
        $upshot = data_get($event, 'upshot');
        $caregory = Str::of($storyline->categories->first()->name)->lower()->is('благо');
        if (is_null($caregory)) {
            return false;
        }
        $lv = $upshot->level;
        $balance_levels = collect(json_decode($storyline->balance))->toArray();
        if (collect($balance_levels)->isEmpty()) {
            return false;
        }
        $price = Arr::first(collect(Str::of($balance_levels[$lv])->explode('|'))->shuffle()->random(1));

        if (Str::of($price)->contains('-')) {
            $price = Str::of($price)->explode('-');
            $price = range((integer)$price[0], $price[1], $price[2] ?? 0);
            $price = collect(collect($price)->shuffle()->sliding(2)->random())->random();
        }

        /**
         * Записываем игроку предложение на время выбора, после нужно поставить в null
         * storyline
         * "put_where" => "{"income": {"type": "disposable", "value": "for_assets"}}"
         */
        if (is_null($upshot->purchase)) {
            $put_where = collect(json_decode($storyline->put_where))->toArray();
            if (!is_null(data_get($put_where, 'expense'))) {
                $put_where = data_set($put_where, 'expense.name', $storyline->purpose_plot);
                $put_where = data_set($put_where, 'expense.price', $price);
            }
            if (!is_null(data_get($put_where, 'income'))) {
                $put_where = data_set($put_where, 'income.name', $storyline->purpose_plot);
                $put_where = data_set($put_where, 'income.price', $price);
            }
            // $data = collect(['name' => $storyline->purpose_plot])->toJson(JSON_PRETTY_PRINT);
            $upshot->update(['purchase' => collect($put_where)->toJson(JSON_PRETTY_PRINT)]);
        }else{
            $price = data_get(json_decode($upshot->purchase), "income.price");
        }
        return Arr::wrap(['price' => $price]);
    }
}
