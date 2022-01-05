<?php

namespace App\Listeners\Recruiting;

use App\Events\Recruiting\ByMessageConditionEvent;
use App\Traits\HelpersBotCommands;
use App\Traits\MessageCollect;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ByMessageConditionListener
{
    use MessageCollect, HelpersBotCommands;

    private $processing = 'last';
    private $delay;

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
     * @param ByMessageConditionEvent $event
     * @return void
     */
    public function handle(ByMessageConditionEvent $event)
    {
        $data = collect($event)->toArray();
        $message = data_get($data, 'message');
        $dialog = data_get($event, 'dialog');
        $upshot = $dialog->upshot->toArray();
        $btn = ' ';
        $reply_markup = $this->getReplyMarkup(Arr::wrap([$btn]), 'reply');
        $this->push($message, $dialog, $reply_markup, 0);
        $code = data_get(json_decode(data_get($message, 'option.using_condition')), 'code');
        //$perform = eval("return $code;");
        $perform = $this->theСonfirmation($code, $upshot);

        /**
         * может быть остановка игры
         */
        if (is_null($perform)) $perform = 0;
        $all_transitions = data_get($message, 'transitions');
        if ($perform) {
            $dialog_next = collect($all_transitions)->first(function ($value, $key) {
                return Str::of(trim(data_get($value, 'name')))->exactly('1');
            });
        } else {
            $dialog_next = collect($all_transitions)->first(function ($value, $key) {
                return Str::of(trim(data_get($value, 'name')))->exactly('0');
            });
        }

        $message = $this->getMessage(class_basename(data_get($dialog_next, 'storylinegable_type')), data_get($dialog_next, 'storylinegable_id'));
        $keyboard = $message->transitions->pluck('name');
        $reply_markup = $this->getReplyMarkup($keyboard, 'reply');
        $will_stop = 1;
        $this->push($message, $dialog, $reply_markup, $will_stop);
        $dialog->update([
            'dialog_id' => $message->id,
            'dialog_type' => class_basename($message->option->optiontable_type)]);
        exit;
    }

    public function push($message, $dialog, $reply_markup, $will_stop)
    {

        $option_delay = $message->option->delay ?? data_get($message, 'option.delay');
        $this->delay = $this->delay + $option_delay;
        $text_slice = $message->caption ?? data_get($message, 'caption');
        $delay_slice = $this->delayType($message->option->delay_type ?? data_get($message, 'option.delay_type'), $this->delay);
        $uri_slice = $message->url ?? data_get($message, 'url');
        $type_slice = class_basename($message->option->optiontable_type ?? data_get($message, 'pivot.storylinegable_type'));
        $text_slice = $this->getCaption(null, $dialog->id, $text_slice);
        $this->pushMessage($dialog->chat_id, $text_slice, $reply_markup, $delay_slice, $allow_sending_without_reply = true, $uri_slice, $type_slice, $this->processing, $will_stop);
    }

    public function theСonfirmation($code, $upshot)
    {
        $purchase = collect(json_decode(data_get($upshot, 'purchase')))->toArray();
        $briefcase = collect(json_decode(data_get($upshot, 'briefcase')))->toArray();
        $fathers_loan = Arr::wrap(['fathers_loan' => (boolean) $this->fathers_loan($briefcase)]);
        $upshot = data_set($upshot, 'purchase', $purchase);
        $upshot = data_set($upshot, 'briefcase', $briefcase);
        $arr = collect()->push($upshot)->push($fathers_loan)->collapse()->toArray();
        
        $generated = Blade::compileString($code);
        ob_start() and extract($arr, EXTR_SKIP);
        try {
            eval('?>' . $generated);
        } catch (\Exception $e) {
            ob_get_clean();
            Log::info('ошибка в компиляции кода для проверки');
            return null;
        }
        return ob_get_clean() ?? '';
    }

    public function fathers_loan($briefcase)
    {
        $briefcase_col = collect(data_get($briefcase,'put_where.income'))->first(function ($v){
            return Str::of(data_get($v, 'name'))->lower()->is('* займ у отца *');
        });
        if($briefcase_col){
            return true;
        }
        return false;
    }
}
