<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\HelpersBotCommands;

class DialogStop
{
    use HelpersBotCommands;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $from_id = data_get($request, 'message.from.id');
        $data_dialog = $this->dialog($from_id);
        if (!is_null($data_dialog) && $data_dialog->will_stop) exit;
        return $next($request);
    }
}
