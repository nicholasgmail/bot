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
use Telegram\Bot\Laravel\Facades\Telegram;

class SendMessageJob implements ShouldQueue
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
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    // public $retryAfter = 0;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       // $this->delay(5);
        // sleep(10);
        Telegram::sendMessage(['chat_id' => $this->data['id'], 'parse_mode'=> 'HTML','text' => $this->data['text'], 'reply_markup' => $this->data['reply_markup']]);
        if(data_get($this->data,'will_stop')) {
            $dialog = DialogTelegram::firstWhere('chat_id', data_get($this->data, 'id'));
            $dialog->update(['will_stop' => 0, 'shown'=>1]);
        }
    }
}
