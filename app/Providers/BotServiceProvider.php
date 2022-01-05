<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Telegram\BotAll;
use App\Services\HiddenButtons;
use App\Services\StickerServiceBot;

class BotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BotAll::class, function ($app) {
            return new HiddenButtons();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
