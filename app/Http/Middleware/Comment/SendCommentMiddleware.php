<?php

namespace App\Http\Middleware\Comment;

use App\Facades\AnswerLogicFacade;
use App\Facades\QuestionLogicFacade;
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
        $questionInfo = QuestionLogicFacade::getQuestionData($request->url_hash);

        // 解答済みチェック
        // ログイン認証済みの場合は解答済みチェック
        // コメント投稿者名をセッションからセット
        if(session('twitter_user_id')){
            $isAnswered = AnswerLogicFacade::isAnswered($questionInfo->id, session('twitter_user_id'));
            $request->merge(['isAnswered' => $isAnswered]);
            $request->merge(['comment_name' => session('name')]);
        } else {
            $isAnswered = AnswerLogicFacade::isAnswered($questionInfo->id, $request->session()->getId());
            $request->merge(['isAnswered' => $isAnswered]);
        }

        $request->merge(['questionInfo' => $questionInfo]);
        $request->merge(['isAnswered' => $isAnswered]);

        return $next($request);
    }
}
