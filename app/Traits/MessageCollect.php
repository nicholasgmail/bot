<?php

namespace App\Traits;


use App\Models\{DialogTelegram, Variable, Game, Image, Message, Storyline, Transition, Video};
use App\Events\Telegram\{MessageEvent, PhotoMessageEvent, VideoMessageEvent};
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram\Bot\Keyboard\Keyboard;
use App\View\Components\Bot\Text;


trait MessageCollect
{
    /**
     * a collection consisting of messages && images && video
     * @param $id
     * @return array
     */
    public function collectStoryline($id)
    {
        $all_collection = collect();
        if (is_null($id)) {
            return null;
        }
        $storyline = Storyline::find($id);
        /**
         * TODO сделать джобера ответа сюжет не найден
         */
        $collection_images = $storyline->images;
        $collection_messages = $storyline->messages;
        $collection_videos = $storyline->videos;

        if ($collection_messages->isNotEmpty()) {
            $mess = $collection_messages->map(function ($item) {
                $message = Message::find($item->id);
                return collect($item)->merge([
                    'priority' => $message->option->priority,
                    'following' => $message->option->following,
                    'expect' => $message->option->expect,
                    'delay' => $message->option->delay,
                    'delay_type' => $message->option->delay_type,
                    'button_type' => $message->option->button_type
                ]);
            });
            if ($mess->isNotEmpty()) {
                $all_collection = $all_collection->merge($mess);
            }
        }
        if ($collection_images->isNotEmpty()) {
            $imag = $collection_images->map(function ($item) {
                $image = Image::find($item->id);
                return collect($item)->merge([
                    'priority' => $image->option->priority ?? 1,
                    'following' => $image->option->following ?? 1,
                    'expect' => $image->option->expect ?? 1,
                    'delay' => $image->option->delay ?? 1,
                    'delay_type' => $image->option->delay_type ?? 1,
                    'button_type' => $image->option->button_type ?? 1
                ]);
            });
            if ($imag->isNotEmpty()) {
                $all_collection = $all_collection->merge($imag);
            }
        }

        if ($collection_videos->isNotEmpty()) {
            $vide = $collection_videos->map(function ($item) {
                $video = Video::find($item->id);
                return collect($item)->merge([
                    'priority' => $video->option->priority ?? 1,
                    'following' => $video->option->following ?? 1,
                    'expect' => $video->option->expect ?? 1,
                    'delay' => $video->option->delay ?? 1,
                    'delay_type' => $video->option->delay_type ?? 1,
                    'button_type' => $video->option->button_type ?? 1
                ]);
            });
            if ($vide->isNotEmpty()) {
                $all_collection = $all_collection->merge($vide);
            }
        }
        return $all_collection;
    }

    /**
     * @param $type
     * @param $id
     * @return mixed
     */
    public function getMessage($type, $id)
    {
        switch ($type) {
            case 'Message' :
                return Message::find($id) ?? null;
            case 'Image' :
                return Image::find($id) ?? null;
            case 'Video' :
                return Video::find($id) ?? null;
            default:
                break;
        };
    }

    /**
     * @param $chat
     * @param $text
     * @param $reply_markup
     * @param $delay
     * @param bool $allow_sending_without_reply
     * @param null $uri
     * @param string $type
     */
    public function pushMessage($chat, $text, $reply_markup = false, $delay, $allow_sending_without_reply = true, $uri = null, $type = 'Message', $processing = 'last', $will_stop = 0, $time_start = 0)
    {
        if ($reply_markup == false) {
            $reply_markup = Keyboard::remove(['selective' => true]);
        }
        $time_end = microtime(true);
        $data = Arr::wrap([
            'id' => $chat,
            'text' => $text,
            'url' => \Telegram\Bot\FileUpload\InputFile::create(env('APP_URL') . $uri) ?? null,
            'reply_markup' => $reply_markup,
            'delay' => $delay,
            'allow_sending_without_reply' => $allow_sending_without_reply,
            'processing' => $processing,
            'will_stop' => $will_stop
        ]);

        switch ($type) {
            case 'Message' :
                event(new MessageEvent($data));
                break;
            case 'Image' :
                event(new PhotoMessageEvent($data));
                break;
            case 'Video' :
                event(new VideoMessageEvent($data));
                break;
            default:
                break;
        };
    }

    /**
     * @param $type
     * @param $id
     * @return array|bool
     */
    public function getKeyboard($message)
    {
        $id = data_get($message, 'pivot.storylinegable_id');
        $type = class_basename(data_get($message, 'pivot.storylinegable_type'));
        $find_message = $this->getMessage($type, $id);
        return $find_message->transitions->pluck('name');
    }

    /**
     * @param $type
     * @param $id
     * @return array|bool
     */
    public function getInlineKeyboard($type, $id)
    {
        $find_message = $this->getMessage($type, $id);
        $pushbuttons = $find_message->pushbutton;
        $transition_ids = $pushbuttons->pluck('pivot.transitiontable_id');
        $dialog_all = Transition::whereIn('id', $transition_ids)->select('name')->get();
        $button_row = $dialog_all->pluck('name')->map(function ($item, $key) use ($transition_ids) {
            return ['text' => $item, 'callback_data' => collect(['tk' => $key, 't_ids' => $transition_ids[$key]])->toJSON()];
        });
        return $button_row->toArray();
    }

    /**
     * @param $keyboard
     * @param $type
     * @return Keyboard
     */
    public function getReplyMarkup($keyboard, $type)
    {
        if (Str::is($type, 'reply')) {
            $first = collect($keyboard)->toArray();
            $first = collect(collect($first)->countBy())->keys();
            $chunk = array_chunk(collect($first)->toArray(), 2);
            $reply_markup = Keyboard::make(['keyboard' => $chunk, 'resize_keyboard' => true,
                'one_time_keyboard' => false])->setResizeKeyboard(true)->setOneTimeKeyboard(false)->setSelective(false);

        } else {
            $reply_markup = Keyboard::make()->inline();
            $button_count = collect($keyboard)->count();
            if ($button_count > 2) {
                $chunk = array_chunk($keyboard, 2);
                foreach ($chunk as $item) {
                    $reply_markup->row(...$item);
                }
            } else {
                $reply_markup = Keyboard::make(['inline_keyboard' => array($keyboard)])->inline();
            }
        }
        return $reply_markup;
    }

    /**
     * @param $message
     * @param $button_text
     * @return mixed
     */
    public function getTransition($transition_ids, $button_text)
    {
        $transition = Transition::whereIn('id', $transition_ids)->get();
        return $transition->first(function ($value, $key) use ($button_text) {
            return Str::of(data_get($value, 'name'))->is('*' . $button_text . '*');
        });
    }

    /**
     * @param $text
     * @param $name
     * @return string
     */
    public function getTextSalut($text, $name)
    {
        $arr_salute = Str::of($text)->explode('||');
        $sort_salute = $arr_salute->sort();
        $salute = Str::upper($sort_salute->random());
        return sprintf('%s %s!' . PHP_EOL, $salute, $name);
    }

    /**
     * @param $message
     * @param $dialog_id
     * @param $text
     * @param null $salute
     * @return string
     */
    public function getCaption($message, $dialog_id, $text)
    {
        $dialog = DialogTelegram::find($dialog_id);
        // $game = Game::find($dialog->game_id);
        $text = Str::of($text)->explode('||');
        $text = $text->random();
        $collection = Str::of($text)->explode(' ');

        $collection_filter = $collection
            ->filter(function ($value, $key) {
                return Str::of($value)->test('/%*%/');
            })
            ->map(function ($val, $key) {
                $between = Str::of($val)->between('%', '%');
                $length = strlen($between);
                return Str::padBoth(Str::of($between)->trim(' '), $length + 2, '%');
            })
            ->toArray();
        if (is_null($dialog->upshot->nick)) {
            $text = Str::replace('%name%', $message->from->first_name ?? '', $text);
        } else {
            $text = Str::replace('%name%', $dialog->upshot->nick ?? '', $text);
        }

        /*$text = Str::replace('%выбор-мес%', $dialog->upshot->months, $text);*/

        /* if (!is_null($game->salute)) {
             // $arr_salute = Str::of($game->salute)->explode('||');
             $arr_emoji = Str::of($game->emoji)->explode('||');
             // $sort_salute = $arr_salute->sort();
             // $salute = Str::upper($sort_salute->random());
             $emoji = $arr_emoji->random();
         } else {
             $salute = 'Привет';
             $emoji = '🤑';
         }*/
        //  $text = Str::replace('%salute%', Str::of($salute)->trim(), $text);
        /*   $text = Str::replace('%эмодзи%', Str::of($emoji)->trim(), $text);*/
        $months = '';
        /* switch ($dialog->upshot->train) {
             case 'first_train':
                 $train = 'первая треня';
                 break;
             case 'regular_train':
                 $train = 'обычная треня';
                 $months = '6, 9 или 12';
                 break;
             case 'raid':
                 $train = 'рейд';
                 break;
             case 'battle':
                 $train = 'батл';
                 $months = '6 или 12';
                 break;
             default:
                 $train = '';
                 break;
         }*/

        /* $text = Str::replace('%мес%', $months, $text);

         $srt = Str::replace('%train_type%', $train, $text);*/

        $variable = Variable::all();

        $variable_filter = $variable->filter(function ($val, $key) use ($collection_filter) {
            return Str::of($val->designation)->contains($collection_filter);
        });

        // Log::info($variable_filter);
        //;
        //$replaced = Str::of($string)->replaceArray('?', ['8:30', '9:00']);
        /*$first = $variable->first(function ($val, $key){
           return true;
        });*/
        $arr_str = $variable_filter->map(function ($value, $key) use ($dialog) {
            $str = new Text($value, $dialog);
            return [$value->designation => $str->render()];
        });

        $combine_arr = Arr::collapse($arr_str);

        // $combine_arr = collect($collection_filter)->combine($arr_str);

        foreach ($combine_arr as $key => $item) {
            $text = Str::replace($key, Str::of($item)->trim() ?? '', $text);
        }


        //$srt = new Text($variable_filter, $dialog);

        return $text;
        // return $text;
    }

}
