<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class WillStop
{
    /**
     * Что можно сделать:
     * 1. Выйти и отправить текст с ошибкой message.sticker
     * 2. Проверку кнопки message.text
     * 3. Вод имени пользователя ошибка если больше символов
     * 4. Передача хода
     * 5. Бросок Кубика
     */
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (data_get($request, 'query.from.is_bot')
            || data_get($request, 'message.from.is_bot')
            || is_null(data_get($request, 'message.from.id'))) exit;
        return $next($request);
    }
}
