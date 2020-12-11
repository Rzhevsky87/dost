<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram;
use App\Models\User;
use App\Models\BotUser;
use App\Services\Bot\BotService;
// Uncomment for debug
// use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    protected static $updates;

    /**
     * Handle of command. Bot Application entry point.
     *
     * @return string
     */
    public function hook()
    {
        Telegram::commandsHandler(true);

        BotService::getBotService(Telegram::getWebhookUpdates())->saveBotUser();

        return 'ok';
    }
}
