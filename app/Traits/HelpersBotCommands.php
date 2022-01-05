<?php

namespace App\Traits;


use App\Models\{DialogTelegram, Kits};
use App\Models\Image;
use App\Models\Message;
use App\Models\Storyline;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram;

trait HelpersBotCommands
{
    /**
     * @param $id
     * @return mixed
     */
    public function dialog($id)
    {
        return DialogTelegram::firstWhere('from_id', $id);
    }

    /**
     * @param $id
     * @param $text
     */
    public function alert($id, $text)
    {
        $data = Arr::wrap([
            'callback_query_id' => $id,
            'text' => $text,
            'show_alert' => false,
            'cache_time' => 30
        ]);
        Telegram::answerCallbackQuery($data);
    }

    /**
     * @param $delay_type
     * @param $first
     * @return \Illuminate\Support\Carbon|int
     */
    public function delayType($delay_type, $delay)
    {
        $out_delay = 0;
        switch ($delay_type) {
            case 'seconds' :
                $out_delay = now()->addSeconds($delay);
                break;
            case 'minutes' :
                $out_delay = now()->addMinutes($delay);
                break;
            case 'hours' :
                $out_delay = now()->addHours($delay);
                break;
            case 'days' :
                $out_delay = now()->addDays($delay);
                break;
            default:
                break;
        };
        return $out_delay;
    }

    /**
     * @param $number
     * @return string|null
     */
    public function diceImage($number)
    {
        $uri = null;
        switch ($number) {
            case 1 :
                $uri = '/storage/images/dice/1.png';
                break;
            case 2 :
                $uri = '/storage/images/dice/2.png';
                break;
            case 3 :
                $uri = '/storage/images/dice/3.png';
                break;
            case 4 :
                $uri = '/storage/images/dice/4.png';
                break;
            case 5 :
                $uri = '/storage/images/dice/5.png';
                break;
            case 6 :
                $uri = '/storage/images/dice/6.png';
                break;
            default:
                break;
        };

        return $uri;
    }

    public function setOfNames($color)
    {
        $kits = Kits::first();
        $men = collect(Str::of($kits->men)->explode(' || '))->shuffle()->random(3);
        $women = collect(Str::of($kits->women)->explode(' || '))->shuffle()->random(3);
        $color_men = $this->searchColorMen($color);
        $men = $men->map(function ($v, $k) use ($color_men) {
            return sprintf("💬 ходит %s\n%s" . PHP_EOL, $v, $color_men[$k]);
        });
        $color_women = $this->searchColorWomen($color);
        $women = $women->map(function ($v, $k) use ($color_women) {
            return sprintf("💬 ходит %s\n%s" . PHP_EOL, $v, $color_women[$k]);
        });
        return $men->zip($women)->map(function ($v){
            return collect($v)->random();
        })->shuffle();
    }

    public function searchColorWomen($color)
    {
        $get = null;
        switch ($color) {
            case 'white' :
                $get = collect(Arr::wrap(['чёрная', 'фиолетовая', 'бирюзовая']));
                break;
            case 'black' :
                $get = collect(Arr::wrap(['белая', 'фиолетовая', 'бирюзовая']));
                break;
            case 'violet' :
                $get = collect(Arr::wrap(['белая', 'чёрная', 'бирюзовая']));
                break;
            case 'turquoise' :
                $get = collect(Arr::wrap(['белая', 'чёрная', 'фиолетовая']));
                break;
            default:
                break;
        };

        return $get;
    }

    public function searchColorMen($color)
    {
        $get = null;
        switch ($color) {
            case 'white' :
                $get = collect(Arr::wrap(['чёрный', 'фиолетовый', 'бирюзовый']));
                break;
            case 'black' :
                $get = collect(Arr::wrap(['белый', 'фиолетовый', 'бирюзовый']));
                break;
            case 'violet' :
                $get = collect(Arr::wrap(['белый', 'чёрный', 'бирюзовый']));
                break;
            case 'turquoise' :
                $get = collect(Arr::wrap(['белый', 'чёрный', 'фиолетовый']));
                break;
            default:
                break;
        };

        return $get;
    }
}
