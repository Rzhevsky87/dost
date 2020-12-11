<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram;
use App\Models\User;
use App\Models\BotUser;

use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    /**
     * Handl of command. Bot Application entry point.
     *
     * @return string
     */
    public function hook()
    {
        Telegram::commandsHandler(true);

        $this->saveBotUser(self::getHookData());

        return 'ok';
    }

    /**
     * Save bot user data
     *
     * @return void
     */
    public function saveBotUser(array $userData)
    {
        foreach($userData as $key => $val) {
            $$key = $val;
        }

        if(empty(BotUser::where('tlgrm_id', $tlgrmId)->first())) {
            BotUser::create($from);
        }
    }

    /**
     * Get data that telegram send
     *
     * @return array
     */
    protected function getHookData()
    {
        $updates = Telegram::getWebhookUpdates();


        $from = $updates['message']['from'];
        $tlgrmId = $from['id'];
        $from['tlgrm_id'] = $tlgrmId;

        // Debug
        // Log::debug($from);

        return compact(
            'from',
            'tlgrmId'
        );
    }
}
