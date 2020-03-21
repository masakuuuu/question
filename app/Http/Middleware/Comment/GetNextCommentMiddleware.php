<?php

namespace App\Http\Middleware\Comment;

use Closure;
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
        $nextCommentList = DB::SELECT('SELECT t1.id, t1.user_name, t1.comment, t1.created_at, t2.name, t2.thumbnail FROM comment_' . $questionInfo->id . ' t1 LEFT JOIN users t2 ON t1.user_id = t2.twitter_id order by t1.created_at DESC;');
        foreach($nextCommentList as $comment){
            $comment->created_at =  date('Y年m月d日 H時i分', strtotime($comment->created_at));
        }
        $request->merge(['nextCommentList' => $nextCommentList]);
        return $next($request);
    }
}
