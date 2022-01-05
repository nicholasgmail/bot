<?php

namespace App\Telegram;

use App\Models\DialogTelegram;
use App\Models\Storyline;
use App\Models\Upshot;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use App\Traits\HelpersBotCommands;
use Telegram\Bot\Keyboard\Keyboard;

/**
 * Class ScreeningCommand
 * @package App\Telegram
 */
class ExamCommand extends Command
{
    use HelpersBotCommands;

    /**
     * @var string
     */
    protected $name = 'exam';

    /**
     * @var string[]
     */
    protected $aliases = ['examcommands'];

    /**
     * @var string Exit Description
     */
    protected $description = 'Тестирование сюжета игры';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $commands = $this->telegram->getCommands();

        $text = '';
        foreach ($commands as $name => $handler) {

            $text .= sprintf('/%s - %s' . PHP_EOL, $name, $handler->getDescription());
        }
        $from = $this->update->getMessage();
        $from_message = $from->get('from');
        $chat_message = $from->get('chat');
        $from_dialog = $this->dialog($from_message->id);

        $storyline = Storyline::firstWhere('point_a', '!==', null);
        $upshot_arr = Arr::wrap([
            "color" => "white", "response_wait" => 1, "day_x" => 0, "nick" => $from_message->first_name, "months" => "12", 'purchase' => null,
            "purpose" => "passive", "train" => "regular_train", "balance" => 120978,
            "briefcase" => data_get($storyline, 'point_a'),
            "months_count" => 6, "level" => "lv_1",
        ]);

        $reply_markup = Keyboard::remove(['selective' => true]);

        $upshot = new Upshot($upshot_arr);
        if ($from_dialog) {
            $new_dialog = $from_dialog->update([
                "from_id" => $from_message->id, "chat_id" => $chat_message->id, "game_id" => 1, "newcomer" => 1, "create_nick" => 0, "dice_roll" => 0, "will_stop" => 0,
                "shown" => 1, "take_it" => 0
            ]);
            $new_dialog = $from_dialog->fresh();
            if (empty($new_dialog->upshot)) {
                $from_dialog->upshot()->create($upshot_arr);
            } else {
                $from_dialog->upshot()->update($upshot_arr);
            }
        } else {
            // $from_dialog = DialogTelegram::find(data_get($from_dialog, 'id'));
            $new_dialog = DialogTelegram::create([
                "from_id" => $from_message->id, "chat_id" => $chat_message->id, "game_id" => 1, "newcomer" => 1, "create_nick" => 0, "dice_roll" => 0, "will_stop" => 0,
                "shown" => 1, "take_it" => 0
            ]);
            $new_dialog->upshot()->create($upshot);
        }

        $text = sprintf('%s' . PHP_EOL, 'Пользователь создан');
        $this->replyWithMessage(compact('text', 'reply_markup'));
        $text = sprintf('%s' . PHP_EOL, 'ведите код доступу');
        $this->replyWithMessage(compact('text'));

        exit;
    }
}

