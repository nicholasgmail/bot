<?php

namespace App\Telegram;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Commands\Command;
use App\Traits\HelpersBotCommands;
use Telegram\Bot\Keyboard\Keyboard;

/**
 * Class ExitCommand
 * @package App\Telegram
 */
class ExitCommand extends Command
{
    use HelpersBotCommands;

    /**
     * @var string
     */
    protected $name = 'exit';

    /**
     * @var string[]
     */
    protected $aliases = ['exitcommands'];

    /**
     * @var string Exit Description
     */
    protected $description = 'Выйти из игры полностью';

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
        $from_dialog = $this->dialog($from_message->id);
        if (is_null($from_dialog)) {
            $reply_markup = Keyboard::remove(['selective' => true]);
            $text = sprintf('%s' . PHP_EOL, 'Выход');
            $this->replyWithMessage(compact('text', 'reply_markup'));
        } else {
            $reply_markup = Keyboard::remove(['selective' => true]);
            if (!is_null($from_dialog->upshot))
                $from_dialog->upshot()->delete();
                $from_dialog->delete();

            $text = sprintf('%s' . PHP_EOL, 'Выход');
            $this->replyWithMessage(compact('text', 'reply_markup'));
            $text = sprintf('%s' . PHP_EOL, 'ведите код доступу для начала игры');
            $this->replyWithMessage(compact('text'));
        }
        exit;
    }
}

