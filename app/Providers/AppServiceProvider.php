<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    //      Этот костыль нужен чтоб генерировать внешние ngrok роуты, но он не пашет
    //      Я решил отстать от костыля и поставить сервак laradocker
    // public function boot(\Illuminate\Http\Request $request)
    // {
    //     if (!empty( env('NGROK_URL') ) && $request->server->has('HTTP_X_ORIGINAL_HOST')) {
    //         $this->app['url']->forceRootUrl(env('NGROK_URL'));
    //     }
    // }
    public function boot()
    {
        //
    }
}
