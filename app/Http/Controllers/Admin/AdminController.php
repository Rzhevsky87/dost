<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BotUser;

class AdminController extends Controller
{
    public function list(Request $request)
    {
        $botUsers = BotUser::all();

        return view('admin.user-list', ['botUsers' => $botUsers]);
    }
}
