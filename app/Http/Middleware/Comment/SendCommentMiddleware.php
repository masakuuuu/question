<?php

namespace App\Http\Middleware\Comment;

use App\Facades\AnswerLogicFacade;
use Closure;

class SendCommentMiddleware
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

        // 解答済みチェック
        $isAnswered = AnswerLogicFacade::isAnswered($questionInfo->id, $request->session()->getId());

        $request->merge(['questionInfo' => $questionInfo]);
        $request->merge(['isAnswered' => $isAnswered]);

        return $next($request);
    }
}
