<?php

namespace App\Http\Middleware\Answer;

use Closure;
use App\Facades\AnswerLogicFacade;
use Illuminate\Support\Facades\DB;

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
        $questionInfo->limit = date('Y年m月d日', strtotime($questionInfo->limit));

        // ログイン認証済みの場合は解答済みチェック
        if(session('twitter_user_id')){
            $isAnswered = AnswerLogicFacade::isAnswered($questionInfo->id, session('twitter_user_id'));
            $request->merge(['isAnswered' => $isAnswered]);
        }

        // 投票結果を取得
        $answerInfo = AnswerLogicFacade::getAnswerData($questionInfo->id);

        // コメント一覧を取得
        $commentList = DB::SELECT('SELECT * FROM comment_' . $questionInfo->id );

        $request->merge(['questionInfo' => $questionInfo]);
        $request->merge(['answerInfo' => $answerInfo]);
        $request->merge(['commentList' => $commentList]);

        return $next($request);
    }
}
