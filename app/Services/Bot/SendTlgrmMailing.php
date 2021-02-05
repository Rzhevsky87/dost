<?php

namespace App\Services\Bot;

use Telegram;
use Telegram\Bot\FileUpload\InputFile;
use App\Models\BotUser;
use App\Models\Mailing;
use Carbon\Carbon;
use App\Services\Bot\BotService;
// Uncomment for debug
// use Illuminate\Support\Facades\Log;


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
            // Uncomment for debug
            // Log::debug([$mailing]);

            // Надо добавить проверку каждого клиента на корректность (заполненно поле chat_id)

            $users = BotUser::where('is_blocked', '!=', true)->get();

            foreach($users as $user) {
                // Реализована отправка сообщения одновременно с текстом через подпись
                $response = Telegram::sendPhoto([
                    'chat_id' => $user->chat_id,
                    'photo' => InputFile::create(storage_path('app/public/mailing/'.$mailing->image)),
                    'caption' => $mailing->text
                ]);
                $messageId = $response->getMessageId();
            }

            $mailing->completed = true;
            $mailing->save();
        }
    }
}
