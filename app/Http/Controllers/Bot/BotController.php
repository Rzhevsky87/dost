<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram;
use App\Models\User;
use App\Models\BotUser;
use App\Services\Bot\BotService;
// Uncomment for debug
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    /**
     * Handle of command. Bot Application entry point.
     *
     * @return string
     */
    public function hook()
    {
        Telegram::commandsHandler(true);
// ==========================================

        $inputData = Telegram::getWebhookUpdates();
        $message = $inputData['message']['text'];


        // Обработка команд
        if($message =='Ввести имя') {
            // отправить юзеру сообщение пжлст введите имя
            // Log::debug($message);
            $response = Telegram::sendMessage([
                'chat_id' => $inputData['message']['chat']['id'],
                'text' => __('bot.auth.sendName')
              ]);
              $messageId = $response->getMessageId();
        }
        if($message == 'Текущая температура воздуха МСК') {
            // отправить юзеру температуру в москве
        }
        if($message == 'Список пользователей') {
            // отправить юзеру список пользователей
        }


        // Обработка НЕ команд
        if(// Это не команда
            empty($inputData['message']['text']['entities'])
            && !preg_match('/\/\w+/m', $message)
            && $message != 'Ввести имя'
            && $message != 'Текущая температура воздуха МСК'
            && $message != 'Список пользователей'
        ) {
            Log::debug($message);
            BotService::getBotService($inputData)->saveBotUser($message);
        }

// ==========================================
        // BotService::getBotService(Telegram::getWebhookUpdates())->saveBotUser();
        // BotService::getBotService($inputData)->saveBotUser();

        return 'ok';
    }
}
