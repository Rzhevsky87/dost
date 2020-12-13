<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram;
use App\Models\User;
use App\Models\BotUser;
use App\Services\Bot\BotService;

use Telegram\Bot\Keyboard\Keyboard;
use GuzzleHttp\Client as Guzzle;

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
        $inputData = !empty($inputData['callback_query'])
            ?$inputData['callback_query']
            :$inputData;
        $service = BotService::getBotService($inputData);

        $message = $inputData['message']['text'];

        $botUser = BotUser::where('tlgrm_id', $inputData['message']['from']['id'])->first();

        $myBot = BotUser::find(29);

        // Обработка команд (не инлайн)
        if($message =='Ввести имя') {
            // отправить юзеру сообщение пжлст введите имя
            // Log::debug($message);
            if(!empty($botUser) && $botUser->custom_username) {
                $response = Telegram::sendMessage([
                    'chat_id' => $inputData['message']['chat']['id'],
                    'text' => "Привет $botUser->custom_username !"
                  ]);
                $messageId = $response->getMessageId();
            }else {
                $response = Telegram::sendMessage([
                    'chat_id' => $inputData['message']['chat']['id'],
                    'text' => __('bot.auth.sendName')
                  ]);
                $messageId = $response->getMessageId();
            }
        }
        if($message == 'Текущая температура воздуха МСК') {
            // отправить юзеру температуру в москве
            // http://api.openweathermap.org/data/2.5/weather?q=Moscow,ru&APPID=f281d3274d38f79776186190985e9601
            $gussle = new Guzzle([
                'base_uri' => 'http://api.openweathermap.org/data/'
            ]);
            $gussleRes = $gussle->request(
                'GET',
                '2.5/weather?q=Moscow,ru&APPID=f281d3274d38f79776186190985e9601'
            );
            $weather = $gussleRes->getBody();
            // Температура приходит в кельвинах
            // формула приведения кельв. а цельсии : 263 K − 273,15 = -10,15 °C
            $temp = floatval(json_decode($weather, false)->main->temp)-273.15;

            $response = Telegram::sendMessage([
                'chat_id' => $inputData['message']['chat']['id'],
                'text' => "Температура воздуха в Москве $temp градусов по цельсию"
              ]);
            $messageId = $response->getMessageId();

            // Debug
            // Log::debug($temp);
        }
        if($message == 'Список пользователей') {
            // отправить юзеру список пользователей
            $inline_keyboard = [[]];
            $allBotUsers = BotUser::all();
            foreach($allBotUsers as $user) {
                array_push(
                    $inline_keyboard[0],
                    Keyboard::inlineButton(['text' => $user->first_name, 'callback_data' => $user->id])
                );
            }

            $reply_markup = Keyboard::make([
                'inline_keyboard' => $inline_keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true,
                // 'callback_data' => 1
            ]);
            $response = Telegram::sendMessage([
                'chat_id' => $inputData['message']['chat']['id'],
                'text' => 'Выберите пользователя',
                'reply_markup' => $reply_markup
            ]);

        }


        // Обработка НЕ команд
        if( // Это не команда
            empty($inputData['message']['text']['entities'])
            && !preg_match('/\/\w+/m', $message)
            && $message != 'Ввести имя'
            && $message != 'Текущая температура воздуха МСК'
            && $message != 'Список пользователей'
            && $inputData['message']['from']['id'] != $myBot->tlgrm_id
            && empty($inputData['data'])
        ) {
            // Log::debug($message);
            // BotService::getBotService($inputData)->saveBotUser($message);
            $service->saveBotUser($message);
        }

        // обработка инлайновых команд
        if(
            !empty($inputData['data'])
            && $inputData['message']['from']['id'] === $myBot->tlgrm_id
        ) {
            $dataRegister = BotUser::find($inputData['data'])->created_at;
            $response = Telegram::sendMessage([
                'chat_id' => $inputData['message']['chat']['id'],
                'text' => "Этот пользователь был зарегистрирован $dataRegister"
              ]);
            $messageId = $response->getMessageId();
        }

// ==========================================
        // BotService::getBotService(Telegram::getWebhookUpdates())->saveBotUser();
        // BotService::getBotService($inputData)->saveBotUser();

        return 'ok';
    }
}
