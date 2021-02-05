<?php

namespace App\Bot\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Actions;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram;

/**
 * Class HelpCommand.
 */
class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'start';

    /**
     * @var array Command Aliases
     */
    protected $aliases = ['startComm'];

    /**
     * @var string Command Description
     */
    protected $description = 'Стартовая команда';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        // Получаю объект соединения через телеграмм
        $tlgrm = Telegram::getWebhookUpdates()['message'];

        // Настриваю клавиатуру (командный интерфейс)
        $keyboard = [
            // Кнопка «Ввести имя»
            // Бот запрашивает имя у пользователя, если имя было введено ранее, то должен сообщить о этом
            // Пользователь вводит имя. Бот должен сохранить его.
            ['Ввести имя'],
            ['Текущая температура воздуха МСК'],
            ['Список пользователей']
        ];
        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        // Отправляю ответ
        $response = \Telegram::sendMessage([
            'chat_id' => $tlgrm['chat']['id'],
            'text' => 'Введите команду',
            'reply_markup' => $reply_markup
        ]);

        $messageId = $response->getMessageId();
    }
}
