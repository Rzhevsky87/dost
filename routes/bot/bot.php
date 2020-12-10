<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Bot\BotController;

Route::post(Telegram::getAccessToken(),  [BotController::class, 'sendResponse']);
