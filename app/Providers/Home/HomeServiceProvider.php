<?php

namespace App\Providers\Home;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Questions;
use App\Facades\QuestionLogicFacade;

class HomeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('home', function ($view) {
            // 急上昇アンケート取得
            $view->with('hot_questions', QuestionLogicFacade::getHotQuestionData());

            // 最新のアンケート取得
            $view->with('current_questions', Questions::where('enable', true)->where('is_open_view', true)->where('limit', '>', date("Y-m-d"))->orderBy('created_at', 'desc')->get());

            // まもなく終了アンケート取得
            $view->with('endSoon_questions', Questions::where('enable', true)->where('is_open_view', true)->where('limit', '>', date("Y-m-d"))->orderBy('limit', 'asc')->get());

            // 集計済みアンケート取得
            $view->with('result_questions', Questions::where('enable', true)->where('is_open_view', true)->where('limit', '<=', date("Y-m-d"))->orderBy('limit', 'asc')->get());
        });
    }
}
