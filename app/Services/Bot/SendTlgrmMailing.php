<?php

namespace App\Services\Bot;

use Telegram;
// use App\Models\User;
use App\Models\BotUser;
use App\Models\Mailing;
use Carbon\Carbon;
use App\Services\Bot\BotService;
// Uncomment for debug
use Illuminate\Support\Facades\Log;

class SendTlgrmMailing
{
    public function __invoke()
    {
        $mailing = Mailing::where(
            'start', '>', Carbon::now(new \DateTimeZone('Asia/Yekaterinburg'))
                ->subMinute(2))
            ->where(
                'start', '<', Carbon::now(new \DateTimeZone('Asia/Yekaterinburg'))
                ->addMinute(2))
            ->where('completed', false)
            ->first();


        if(!empty($mailing)) {
            Log::debug([$mailing]);

            $users = BotUser::where('is_blocked', '!=', true)->get();

            foreach($users as $user) {
                $response = Telegram::sendMessage([
                    'chat_id' => $user->chat_id,
                    'text' => $mailing->text,
                    // 'photo' => "public/mailing/$mailing->image",
                    // 'caption' => 'Some caption'
                ]);
                $messageId = $response->getMessageId();
            }

            $mailing->completed = true;
            $mailing->save();
        }
    }
}
