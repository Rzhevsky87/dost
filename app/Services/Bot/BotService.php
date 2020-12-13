<?php

namespace App\Services\Bot;

use Telegram;
use App\Models\User;
use App\Models\BotUser;
// Uncomment for debug
// use Illuminate\Support\Facades\Log;

class BotService
{
    /**
     * Name this class
     * Testing variable
     */
    public $className = __CLASS__;

    /**
     * Input telegramm data
     */
    protected static $updates;


    /**
     * Return new bot service object
     *
     * @return self
     */
    public static function getBotService($input)
    {
        static::$updates = $input;
        return new static($input);
    }

    /**
     * Save bot user data to Database
     *
     * @param string $customUserName
     *
     * @return void
     */
    public function saveBotUser($customUserName = null)
    {
        $tlgrmUser = $this->getTlgrmUser();
        $tlgrmUser['tlgrm_id'] = $tlgrmUser['id'];
        $tlgrmUser['custom_username'] = $customUserName;

        // Пытаемся извлечь из базы текущего юзера, если такого нет вернется null
        $botUser = BotUser::where('tlgrm_id', $tlgrmUser['tlgrm_id'])->first();

        // Если юзера нет, создаем нового
        if(empty($botUser)) {
            BotUser::create($tlgrmUser);
        }
        // Если юзер есть, добавляем ему отправленное пользователем имя
        if(!empty($botUser) && !$botUser->custom_username) {
            $botUser->custom_username = $tlgrmUser['custom_username'];
            $botUser->save();
        }
        if(!empty($botUser) && $botUser->custom_username) {
            $response = Telegram::sendMessage([
                'chat_id' => self::$updates['message']['chat']['id'],
                'text' => "Привет $botUser->custom_username !"
              ]);
            $messageId = $response->getMessageId();
        }
    }

    /**
     * Return user that send this message
     *
     * @return array
     */
    public function getTlgrmUser()
    {
        return self::$updates['message']['from'];
    }

    /**
     * Create new App\Services\Bot\BotService
     * Debug method
     *
     * @return App\Services\Bot\BotService
     */
    public static function testService()
    {
        return new static();
    }

    /**
     * Return name of this class
     * Debug method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->className;
    }
}
