<?php

namespace App\Providers\Question;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use App\Logic\QuestionLogic;

class QuestionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('QuestionLogic', function (Application $app) {
            return new QuestionLogic();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', 'App\Http\ViewComposers\QuestionComposer');
    }
}
