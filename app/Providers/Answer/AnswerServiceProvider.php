<?php

namespace App\Providers\Answer;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use App\Logic\AnswerLogic;

class AnswerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('AnswerLogic', function (Application $app) {
            return new AnswerLogic();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', 'App\Http\ViewComposers\AnswerComposer');
    }
}
