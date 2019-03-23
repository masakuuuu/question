<?php

namespace App\Http\Middleware\Answer;

use Closure;
use App\Facades\AnswerLogicFacade;

class ViewAnswerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // URLハッシュから質問情報を取得
        $questionInfo = AnswerLogicFacade::getQuestionData($request->url_hash);
        $questionInfo['limit'] = date('Y年m月d日', strtotime($questionInfo['limit']));

        // 投票結果を取得
        $answerInfo = AnswerLogicFacade::getAnswerData($questionInfo->id);

        $request->merge(['questionInfo' => $questionInfo]);
        $request->merge(['answerInfo' => $answerInfo]);

        return $next($request);
    }
}
