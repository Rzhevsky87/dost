<?php

namespace App\Bot\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Actions; // служат для отправки действия (пример : набирает сообщение у бота)
use Telegram\Bot\Keyboard\Keyboard;

/**
 * Class HelpCommand.
 */
class HellowCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'hellow';

    /**
     * @var array Command Aliases
     */
    protected $aliases = ['hellow to user'];

    /**
     * @var string Command Description
     */
    protected $description = 'Say Hellow to user';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        // Отправляем действие - печатает сообщение
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        $this->replyWithMessage(['text' => 'Hellow!']);

        $tlgrmUser = \Telegram::getWebhookUpdates()['message'];
        $text = sprintf('%s: %s'.PHP_EOL, 'Чат', $tlgrmUser['from']['id']);
        $text .= sprintf('%s: %s'.PHP_EOL, 'User name', $tlgrmUser['from']['username']);

        // $keyboard = [
        //     ['7', '8', '9'],
        //     ['4', '5', '6'],
        //     ['1', '2', '3'],
        //          ['0']
        // ];

        $keyboard = [
            ['1'],
            ['2'],
            ['3']
        ];

        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $response = \Telegram::sendMessage([
            'chat_id' => $tlgrmUser['chat']['id'],
            'text' => 'Подсказка уюзеру',
            'reply_markup' => $reply_markup
        ]);

        $messageId = $response->getMessageId();

        $this->replyWithMessage(compact('text'));
    }
}
