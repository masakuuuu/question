<?php

namespace App\Http\Middleware\Question;

use Closure;
use App\Facades\AnswerLogicFacade;

class ViewQuestionMiddleware
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

        // 質問iDをキーにして選択肢情報を取得
        $choiceInfo = AnswerLogicFacade::getChoiceData($questionInfo->id);

        $request->merge(['questionInfo' => $questionInfo]);
        $request->merge(['choiceInfo' => $choiceInfo]);

        return $next($request);
    }
}
