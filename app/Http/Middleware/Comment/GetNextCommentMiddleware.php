<?php

namespace App\Http\Middleware\Comment;

use Closure;
use App\Facades\QuestionLogicFacade;
use Illuminate\Support\Facades\DB;

class GetNextCommentMiddleware

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
        // 質問テーブルからデータを取得
        $questionInfo = QuestionLogicFacade::getQuestionData($request->url_hash);

        // コメントを取得(5件ずつ)
        $nextCommentList = DB::SELECT('SELECT t1.id, t1.user_name, t1.comment, t1.created_at, t2.name, t2.thumbnail FROM comment_' . $questionInfo->id . ' t1 LEFT JOIN users t2 ON t1.user_id = t2.twitter_id where t1.id < :id order by t1.created_at DESC LIMIT 5;',['id' => $request->commentId]);
        foreach($nextCommentList as $comment){
            $comment->created_at =  date('Y年m月d日 H時i分', strtotime($comment->created_at));
        }
        $request->merge(['nextCommentList' => $nextCommentList]);
        return $next($request);
    }
}
