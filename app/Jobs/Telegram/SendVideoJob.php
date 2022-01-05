<?php

namespace App\Jobs\Telegram;

use App\Models\DialogTelegram;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram;

class SendVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 1;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data=[
            'chat_id' => data_get($this->data, 'id'),
            'video' => data_get($this->data, 'url'),
            'caption' => data_get($this->data, 'text'),
            'reply_markup' => data_get($this->data, 'reply_markup'),
            'parse_mode'=> 'HTML',
            'supports_streaming'=> true,
            'disable_notification'=>false
        ];
        //$this->timeout = data_get($this->data, 'data.delay');
        Telegram::sendVideo($data);
        if(data_get($this->data,'will_stop')) {
            $dialog = DialogTelegram::firstWhere('chat_id', data_get($this->data, 'id'));
            $dialog->update(['will_stop' => 0, 'shown'=>1]);
        }
    }
}
