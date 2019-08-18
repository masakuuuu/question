<?php

namespace App\Http\Middleware\Answer;

use Closure;
use App\Facades\AnswerLogicFacade;

class AnswerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 認証してアンケート回答の場合の初期値セット
        if(session('url_hash')){
            $request->merge(['url_hash' => session('url_hash')]);
        }

        if (AnswerLogicFacade::checkQuestionLimit($request->url_hash)) {
            $request->merge(['questionLimit' => true]);
        } else {
            $request->merge(['questionLimit' => false]);
        }

        // URLハッシュから質問情報を取得
        $questionInfo = AnswerLogicFacade::getQuestionData($request->url_hash);

        $questionInfo->limit = date('Y年m月d日', strtotime($questionInfo->limit));

        // 質問iDをキーにして選択肢情報を取得
        $choiceInfo = AnswerLogicFacade::getChoiceData($questionInfo->id);

        // ログイン認証済みの場合は解答済みチェック
        if(session('twitter_user_id')){
            $isAnswered = AnswerLogicFacade::isAnswered($questionInfo->id, session('twitter_user_id'));
            $request->merge(['isAnswered' => $isAnswered]);
        }

        $request->merge(['questionInfo' => $questionInfo]);
        $request->merge(['choiceInfo' => $choiceInfo]);

        return $next($request);
    }
}
