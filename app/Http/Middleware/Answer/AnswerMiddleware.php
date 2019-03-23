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
        // 回答可能なアンケートかのチェック
        if (AnswerLogicFacade::checkQuestionLimit($request->url_hash)) {
            $request->merge(['questionLimit' => true]);
        } else {
            $request->merge(['questionLimit' => false]);
        }
        // URLハッシュから質問情報を取得
        $questionInfo = AnswerLogicFacade::getQuestionData($request->url_hash);

        $questionInfo['limit'] = date('Y年m月d日', strtotime($questionInfo['limit']));

        // 質問iDをキーにして選択肢情報を取得
        $choiceInfo = AnswerLogicFacade::getChoiceData($questionInfo->id);

        // 解答済みチェック
        $isAnswered = AnswerLogicFacade::isAnswered($questionInfo->id, $request->session()->getId());


        $request->merge(['questionInfo' => $questionInfo]);
        $request->merge(['choiceInfo' => $choiceInfo]);
        $request->merge(['isAnswered' => $isAnswered]);


        return $next($request);
    }
}
