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

class SendPhotoJob implements ShouldQueue
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
    /*public $timeout = 500;
    public $sleep = 500;*/


    /* public function delay($delay)
     {
         return $delay;
     }*/
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'chat_id' => data_get($this->data, 'id'),
            'photo' => data_get($this->data, 'url'),
            'parse_mode'=> 'HTML',
            'caption' => data_get($this->data, 'text'),
            'reply_markup' => data_get($this->data, 'reply_markup')
        ];
        Telegram::sendPhoto($data);
        if(data_get($this->data,'will_stop')) {
            $dialog = DialogTelegram::firstWhere('chat_id', data_get($this->data, 'id'));
            $dialog->update(['will_stop' => 0, 'shown'=>1]);
        }
    }
}
