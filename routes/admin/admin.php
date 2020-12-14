<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Bot\BotController;
use App\Http\Controllers\Admin\AdminController;


Route::get('admin',  [AdminController::class, 'list'])->name('admin');

Route::get('admin/{botUser}', [AdminController::class, 'show'])->name('admin.show');

Route::get('admin/block/{botUser}', [AdminController::class, 'block'])->name('admin.block');
