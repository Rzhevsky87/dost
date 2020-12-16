<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BotUser;
use App\Models\Mailing;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

// Uncomment for debug
use Illuminate\Support\Facades\Log;

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
        $botUser->is_blocked = $botUser->is_blocked ? false : true;
        $botUser->save();

        return redirect()->route('admin.show', [$botUser]);
    }

    public function mailing()
    {
        return view('admin.mailing');
    }

    public function createMailing(Request $request)
    {
        // dd($request->start, new Carbon($request->start));
        if ($request->isMethod('post') && $request->file('mailingFile')) {

            $file = $request->file('mailingFile');
            $upload_folder = 'public/mailing';
            $filename = $file->getClientOriginalName(); // image.jpg

            // Log::debug([$upload_folder, $filename]);
            Storage::putFileAs($upload_folder, $file, $filename);


            Mailing::create(
                [
                    'name' => $request->name,
                    'text' => $request->text,
                    'image' => $filename,
                    'start' => !empty($request->start)
                        ? new Carbon($request->start) : Carbon::now()
                ]
            );
        }
    }
}
