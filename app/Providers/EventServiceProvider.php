<?php

namespace App\Providers;



use App\Models\Upshot;
use App\Events\Telegram\{MessageEvent, PhotoMessageEvent, VideoMessageEvent};
use App\Events\Engine\{DiceEvent, BladeTextEvent, LevelEvent, FilterSorilineEvent, TestSorilineEvent, PadSorilineEvent};
use App\Events\Recruiting\{PointASorilineEvent, BriefcaseSorilineEvent, CharityEvent, ByMessageConditionEvent};
use App\Listeners\{MessageTelegramListeners, PhotoMessageListener, VideoMessageListener};
use App\Listeners\Engine\{DiceListener, BladeTextListener, LevelListener, FilterSorilineListener, TestSorilineListener, PadSorilineListener};
use App\Listeners\Recruiting\{PointASorilineListener, BriefcaseSorilineListener, CharityListener, ByMessageConditionListener};
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MessageEvent::class => [
            MessageTelegramListeners::class,
        ],
        PhotoMessageEvent::class => [
            PhotoMessageListener::class,
        ],
        VideoMessageEvent::class => [
            VideoMessageListener::class,
        ],
        DiceEvent::class => [
            DiceListener::class,
        ],
        LevelEvent::class => [
            LevelListener::class,
        ],
        BladeTextEvent::class => [
            BladeTextListener::class,
        ],
        FilterSorilineEvent::class => [
            FilterSorilineListener::class,
        ],
        PointASorilineEvent::class => [
            PointASorilineListener::class,
        ],
        BriefcaseSorilineEvent::class => [
            BriefcaseSorilineListener::class,
        ],
        CharityEvent::class => [
            CharityListener::class,
        ],
        TestSorilineEvent::class => [
            TestSorilineListener::class,
        ],
        PadSorilineEvent::class => [
            PadSorilineListener::class,
        ],
        ByMessageConditionEvent::class => [
            ByMessageConditionListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
