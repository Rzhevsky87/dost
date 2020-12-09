<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Tests\TestController;

// old style
Route::get('testBotAcces',  'TestController@tlgrmTest')->name('testBotAcces');
// new style
Route::get('testBotAccesInJson',  [TestController::class, 'tlgrmTestReturnJsom'])
    ->name('testBotAccesInJson');
