<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function sendComment(Request $request)
    {
        // 解答済みのアンケート出ない場合はコメント追加させない
        if(!$request->isAnswered){
            return redirect('AnswerController@viewAnswer', ['request' => $request]);
        }

        // コメントの登録処理
        DB::INSERT('INSERT INTO comment_' . $request->questionInfo->id . ' (user_id, user_name, comment) VALUES(:user_id, :user_name, :comment) ',
            [
                'user_id' => session('twitter_user_id'),
                'user_name' => session('name'),
                'comment' => $request->comment
            ]);

        return redirect()->action(
            'AnswerController@viewAnswer', ['url_hash' => $request->url_hash]);

    }
}
