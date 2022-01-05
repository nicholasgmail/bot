<?php

namespace App\Traits;


use App\Models\Storyline;
use Illuminate\Support\Facades\Log;

trait HelpersStoryline
{

    public function getCollectStoryline($id)
    {
        try {
            $collect = collect();
            $strl = Storyline::find($id);
            $messages = $strl->messages;
            $clMs = $messages->map(function ($value, $key) {
                $transitons = $value->transitions;
                $option = $value->option;
                return collect($value)->put('transitions', $transitons)->put('option', $option);
            });
            $images = $strl->images;
            $clIm = $images->map(function ($value, $key) {
                $transitons = $value->transitions;
                $option = $value->option;
                return collect($value)->put('transitions', $transitons)->put('option', $option);
            });
            $videos = $strl->videos;
            $clVd = $videos->map(function ($value, $key) {
                $transitons = $value->transitions;
                $option = $value->option;
                return collect($value)->put('transitions', $transitons)->put('option', $option);
            });

            return $collect->merge($clIm)->merge($clMs)->merge($clVd)->sortBy('option.priority');
        } catch (\Throwable $e) {
            Log::info($e);
        }
        return false;
    }
}
