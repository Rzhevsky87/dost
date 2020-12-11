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
     * @return void
     */
    public function saveBotUser()
    {
        $user = $this->getBotUser();
        $user['tlgrm_id'] = $user['id'];

        if(empty(BotUser::where('tlgrm_id', $user['tlgrm_id'])->first())) {
            BotUser::create($user);
        }
    }

    /**
     * Return user that send this message
     *
     * @return array
     */
    public function getBotUser()
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
