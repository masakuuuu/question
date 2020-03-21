<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function sendComment(Request $request)
    {
        // 解答済みのアンケート出ない場合はコメント追加させない
        if (!$request->isAnswered) {
            return redirect('AnswerController@viewAnswer', ['request' => $request]);
        }

        // コメントの登録処理
        // ログイン済みの場合
        $insertDate = date("Y-m-d H:i:s", time());
        
        if (session('twitter_user_id')) {
            DB::INSERT('INSERT INTO comment_' . $request->questionInfo->id . ' (user_id, user_name, comment, created_at, updated_at) VALUES(:user_id, :user_name, :comment, :created_at, :updated_at) ',
                [
                    'user_id' => session('twitter_user_id'),
                    'user_name' => session('name'),
                    'comment' => $request->comment,
                    'created_at' => $insertDate,
                    'updated_at' => $insertDate
                ]);
        } else {
            DB::INSERT('INSERT INTO comment_' . $request->questionInfo->id . ' (user_id, user_name, comment, created_at, updated_at) VALUES(:user_id, :user_name, :comment, :created_at, :updated_at) ',
                [
                    'user_id' => $request->session()->getId(),
                    'user_name' => $request->comment_name,
                    'comment' => $request->comment,
                    'created_at' => $insertDate,
                    'updated_at' => $insertDate
                ]);
        }

        if (session('twitter_user_id')) {
            return redirect()->action(
                'AnswerController@viewAnswer', ['url_hash' => $request->url_hash]);
        } else {
            return redirect()->action(
                'AnswerController@gestViewAnswer', ['url_hash' => $request->url_hash]);
        }

    }
}
