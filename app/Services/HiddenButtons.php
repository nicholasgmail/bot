<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Traits\{MessageCollect, HelpersBotCommands, HelpersStoryline};
use App\Contracts\Telegram\BotAll;
use Telegram\Bot\Keyboard\Keyboard;

class HiddenButtons implements BotAll
{
    use MessageCollect, HelpersBotCommands, HelpersStoryline;

    private $processing = 'last';
    private $del;
    private $time_start;


    public function sendMessageFollowing($id, $slices, $dialog)
    {
        $this->slices($id, $slices, $dialog);
    }

    /**
     * @param $id
     * @param $slices
     * @param $dialog
     * @return bool
     * обработка входного масива с даными
     */
    public function slices($id, $slices, $dialog)
    {
        $btn = ' ';
        $reply_markup = $this->getReplyMarkup(Arr::wrap([$btn]), 'reply');
        foreach ($slices as $slice) {

            if (!data_get($slice, 'option.following')) {
                $keyboard = $this->getKeyboard($slice);
                $reply_markup = $this->getReplyMarkup($keyboard, 'reply');
                $storyline_id = data_get($slice, 'pivot.storyline_id');
                $dialog_id = data_get($slice, 'pivot.storylinegable_id');
                $dialog_type = class_basename(data_get($slice, 'pivot.storylinegable_type'));
                $this->updateDialog($dialog, $storyline_id, $dialog_id, $dialog_type);
                $will_stop = 1;
                $this->slice($id, $reply_markup, $slice, $dialog, $will_stop);
                exit;
            }
            $this->time_start = microtime(true);
            $this->slice($id, $reply_markup, $slice, $dialog);
            if (collect(data_get($slice, 'transitions'))->isNotEmpty()) {
                /**
                 * нужно запустить функцию которая вернет сообщение из перехода
                 */

                $this->next($id, $reply_markup, $dialog, data_get($slice, 'transitions'), $slice);
                exit;
            }
        };
        exit;
    }

    /**
     * @param $id
     * @param $reply_markup
     * @param $dialog
     * @param $transition
     * луп для отправки сообщений циклически
     */
    public function next($id, $reply_markup, $dialog, $transition, $slice_last = null)
    {
        $transition_random = $this->transitionRandom($transition);
        $transition = $transition_random->isEmpty() ? $transition->first() : $transition_random;
        $will_stop = 0;
        /**
         * если нет перехота ищем следующий
         */
        if (is_null($transition)) {
            $this->following($id, $dialog);
        } else {
            $name = data_get($transition, 'name');
            if (data_get($transition, 'storylinegable_id')) {
                $message_type = data_get($transition, 'storylinegable_type');
                $message_id = data_get($transition, 'storylinegable_id');
                $slice = $this->getMessage(class_basename($message_type), $message_id);
                $storyline = $slice->storyline;
                $storyline_id = data_get($storyline->first(), 'id');
                $dialog_id = data_get($storyline->first(), 'pivot.storylinegable_id');
                $dialog_type = class_basename(data_get($storyline->first(), 'pivot.storylinegable_type'));
                $this->updateDialog($dialog, $storyline_id, $dialog_id, $dialog_type);
                /*  $dialog->update([
                      'storyline_id' => data_get($storyline->first(), 'id'),
                      'dialog_id' => data_get($storyline->first(), 'pivot.storylinegable_id'),
                      'dialog_type' => class_basename(data_get($storyline->first(), 'pivot.storylinegable_type'))]);*/
                $transitions = $slice->transitions;
                $option = $slice->option;
                $slice = collect($slice)->put('transitions', $transitions)->put('option', $option);
                if (is_null($transitions)) {
                    $this->following($id, $dialog);
                    exit;
                }
            } else {
                $transitions = data_get($slice_last, 'transitions');
                $option = data_get($slice_last, 'option');
            }

            if (!data_get($option, 'following')) {
                $keyboard = collect($transitions)->pluck('name')->toArray();
                $reply_markup = $this->getReplyMarkup($keyboard, 'reply');
            } else {
                $btn = $name ?? ' ';
                $reply_markup = $this->getReplyMarkup(Arr::wrap([$btn]), 'reply');
            }
            $this->time_start = microtime(true);
            if (!is_null($slice)) {
                if (data_get($option, 'following') && !is_null($transitions)) {
                    $this->slice($id, $reply_markup, $slice, $dialog);
                } else {
                    $will_stop = 1;
                    $this->slice($id, $reply_markup, $slice, $dialog, $will_stop);
                }
            }
        }
        /**
         * если нет перехода или он пустой
         */
        if (data_get($option, 'following') && !is_null($transitions)) {
            $this->next($id, $reply_markup, $dialog, $transitions);
        }
        exit;
    }

    /**
     * @param $id
     * @param $reply_markup
     * @param $slice
     * @param $dialog
     * @param int $will_stop
     * отправка сообщения
     */
    public
    function slice($id, $reply_markup, $slice, $dialog, $will_stop = 0)
    {
        /**
         * нужно использовать рандом
         */
        $option_delay = data_get($slice, 'option.delay');
        $text_slice = data_get($slice, 'caption');
        $this->del = (integer)$this->del + (integer)$option_delay;
        $delay_slice = $this->delayType(data_get($slice, 'option.delay_type'), $this->del);
        $uri_slice = data_get($slice, 'url');
        $type_slice = class_basename(data_get($slice, 'option.optiontable_type'));
        $text_slice = $this->getCaption($text_slice, $dialog->id, $text_slice);
        $this->pushMessage($id, $text_slice, $reply_markup, $delay_slice, $allow_sending_without_reply = true, $uri_slice, $type_slice, $this->processing, $will_stop, $this->time_start);
    }

    /**
     * @param $transitions
     * @return \Illuminate\Support\Collection
     * определение рандомногоперехода 1-20
     */
    public
    function transitionRandom($transitions)
    {
        $numb = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]);
        $random = collect(collect($numb->shuffle()->sliding(4, 2))->random())->random();
        $transitions = $transitions->filter(function ($val, $key) {
            return !is_null(data_get($val, 'weight')) && data_get($val, 'btn_random');
        })->first(function ($val, $key) use ($random) {
            $arr = Str::of(data_get($val, 'weight'))->explode('-');
            $collection = collect()->range($arr[0], $arr[1] ?? $arr[0]);
            return $collection->search($random);
        });
        if (collect($transitions)->isEmpty()) {
            return collect();
        }
        return collect($transitions);
    }

    /**
     * @param $transitions
     * @return \Illuminate\Support\Collection
     * определение рандомногоперехода 1-20
     */
    public
    function transitionName($transitions)
    {
        $transitions = $transitions->filter(function ($val, $key) {
            return is_null(data_get($val, 'weight')) && is_null(data_get($val, 'name'));
        })->first();
        if (collect($transitions)->isEmpty()) {
            return collect();
        }
        return collect($transitions);
    }

    /**
     * @param $chat_id
     * @param $dialog
     *
     */
    public
    function following($chat_id, $dialog)
    {
        $messages = $this->getCollectStoryline($dialog->storyline_id);
        $messages = $messages->filter(function ($value, $key){
            return !$value->option->pad;
        })->sortBy('option.priority');
        $get_message_first = null;
        $dialog_next = null;
        $class_dialog = 'App\\Models\\' . $dialog->dialog_type;
        $id_dialog = $dialog->dialog_id;
        $get_first = $messages->first(function ($value, $key) use ($id_dialog, $class_dialog) {
            return data_get($value, 'id') == $id_dialog && data_get($value, 'pivot.storylinegable_type') == $class_dialog;
        });
        $get_message_following = $messages->filter(function ($value, $key) use ($get_first) {
            return data_get($value, 'option.priority') >= data_get($get_first, 'option.priority')
                && data_get($value, 'option.priority') <= data_get($get_first, 'option.priority')
                && data_get($value, 'option.following')
                && !data_get($value, 'option.expect');
        });
        if (collect($get_message_following)->isEmpty()) {
            $get_message_following = $messages->first(function ($value, $key) use ($get_message_first) {
                return data_get($value, 'option.priority') > data_get($get_message_first, 'option.priority');
            });
        } else {
            $get_message_first = $messages->first(function ($value, $key) use ($get_message_following) {
                $get_message_last = $get_message_following->last();
                return data_get($value, 'option.priority') > data_get($get_message_last, 'option.priority')
                    && !data_get($value, 'option.following');
            });
            $get_message_following = collect($get_message_following)->push($get_message_first);
        }
        $this->sendMessageFollowing($chat_id, $get_message_following, $dialog);
    }

    public
    function exceptMessage($id, $text)
    {
        $text = sprintf('%s' . PHP_EOL, $text);
        $this->pushMessage($id, $text, false, 0);
        return true;
    }


    public
    function updateDialog($dialog, $storyline_id, $dialog_id, $dialog_type)
    {
        $dialog->update([
            'storyline_id' => $storyline_id,
            'dialog_id' => $dialog_id,
            'dialog_type' => $dialog_type]);
    }
}
