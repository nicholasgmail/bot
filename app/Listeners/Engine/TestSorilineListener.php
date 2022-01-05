<?php

namespace App\Listeners\Engine;

use App\Events\Engine\TestSorilineEvent;
use App\Events\Telegram\MessageEvent;
use App\Events\Telegram\PhotoMessageEvent;
use App\Events\Telegram\VideoMessageEvent;
use App\Models\DialogTelegram;
use App\Models\Storyline;
use App\Models\Upshot;
use App\Traits\HelpersBotCommands;
use App\Traits\MessageCollect;
use App\Traits\HelpersStoryline;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TestSorilineListener
{
    use MessageCollect, HelpersBotCommands, HelpersStoryline;

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
     * @param TestSorilineEvent $event
     * @return void
     */
    public function handle(TestSorilineEvent $event)
    {
        try {
            $code = Str::of(data_get($event, 'test'))->trim();
            $dialog_id = data_get($event, 'dialog');
            $storyline = Storyline::all();
            $first = $storyline->first(function ($value, $key) use ($code) {
                return Str::of(data_get($value, 'hash'))->is($code);
            });
            $dialog = DialogTelegram::find($dialog_id);
            $storyline_id = data_get($first, 'id');
            if (!$storyline_id) {
                return false;
            }
            $messages = $this->getCollectStoryline($storyline_id);
            $messages = $messages->filter(function ($value, $key) {
                return !data_get($value, "option.pad");
            });
            $dialog->update([
                'will_stop' => 0,
                'shown' => 0,
                'storyline_id' => data_get($messages->first(), 'pivot.storyline_id'),
                'dialog_id' => data_get($messages->first(), 'pivot.storylinegable_id'),
                "dialog_type" => class_basename(data_get($messages->first(), 'pivot.storylinegable_type'))
            ]);

            $upshot = [
                "color" => "white", "response_wait" => 1, "day_x" => 0, "nick" => 'Тест ник', "months" => "12",
                "purpose" => "passive", "train" => "regular_train", "balance" => 120978,
                "briefcase" => data_get($storyline, 'point_a'),
                "name" => null, "complexity" => null, "list_storyline" => null, "months_count" => 6, "game_count" => null, "client" => null, "level" => "lv_1", "step_number" => null, "step_map" => null
            ];

            $create_upshot = new Upshot($upshot);
            $dialog->upshot()->save($create_upshot);
            return true;
        } catch (\Throwable $e) {
            Log::info($e);
        }
        return false;
    }
}
