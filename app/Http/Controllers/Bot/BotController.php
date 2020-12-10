<?php

namespace App\Http\Controllers\Bot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BotController extends Controller
{
    /**
     * Example for documentation
     *
     * @return string
     */
    public function sendResponse()
    {
        $update = \Telegram::commandsHandler(true);

        // Commands handler method returns an Update object.
        // So you can further process $update object
        // to however you want.

        return 'ok';
    }
}
