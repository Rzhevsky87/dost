<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Telegram\Bot\Objects\User
     */
    public static $response;


    function __construct()
    {
        self::$response = \Telegram::getMe();
    }


    /**
     * Simple browser test what telegrem bot is acess
     *
     * @return void
     */
    public function tlgrmTest()
    {
        $vars = self::getTelegram();

        dd(self::$response, $vars['botId'], $vars['firstName'], $vars['username']);
    }

    /**
     * Simple browser test what telegrem bot is acess and return json
     *
     * @return json
     */
    public function tlgrmTestReturnJsom()
    {
        $vars = self::getTelegram();

        return response()->json([
            'botId' => $vars['botId'],
            'firstName' => $vars['firstName'],
            'username' => $vars['username']
        ]);
    }

    /**
     * Get tlgrm boot variables for test request
     *
     * @return array
     */
    protected function getTelegram()
    {
        $botId = self::$response->getId();
        $firstName = self::$response->getFirstName();
        $username = self::$response->getUsername();

        return [
            'botId' => $botId,
            'firstName' => $firstName,
            'username' => $username
        ];
    }
}
