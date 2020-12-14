<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BotUser;

class AdminController extends Controller
{
    public function list()
    {
        $botUsers = BotUser::all();

        return view('admin.user-list', ['botUsers' => $botUsers, 'i' => 1]);
    }

    public function show(BotUser $botUser)
    {
        return view('admin.user-show', ['botUser' => $botUser]);
    }

    public function block(BotUser $botUser)
    {
        return __METHOD__;
    }
}
