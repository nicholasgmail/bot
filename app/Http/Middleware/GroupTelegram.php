<?php

namespace App\Http\Middleware;

use App\Events\Telegram\MessageEvent;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use App\Models\Kits;
use App\Traits\{HelpersStoryline};
use Illuminate\Support\Str;


class GroupTelegram
{
    use HelpersStoryline;

    public function stickerError($chat_id)
    {
        $get_error = Kits::first();
        $text = collect(Str::of($get_error->mistake)->explode(' || '))->shuffle()->random(1);
        $data = Arr::wrap([
            'id' => $chat_id,
            'text' => Arr::first($text),
            'url' => null,
            'reply_markup' => false,
            'delay' => 0,
            'will_stop' => 1
        ]);
        event(new MessageEvent($data));
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (data_get($request, 'message.sticker')) {
            $this->stickerError(data_get($request, 'message.chat.id'));
            exit;
        };
        return $next($request);
    }
}
