<?php

namespace App\Providers\User;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use App\Logic\UserLogic;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('UserLogic', function (Application $app) {
            return new UserLogic();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        {
            View::composer('*', 'App\Http\ViewComposers\UserComposer');
        }
    }
}
