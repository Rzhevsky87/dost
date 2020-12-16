<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;


Route::get('/',  [AdminController::class, 'list'])->name('admin');

Route::get('show/{botUser}', [AdminController::class, 'show'])->name('admin.show');

Route::get('block/{botUser}', [AdminController::class, 'block'])->name('admin.block');

Route::get('mailing', [AdminController::class, 'mailing'])->name('admin.mailing');

Route::post('createMailing', [AdminController::class, 'createMailing'])->name('admin.createMailing');
