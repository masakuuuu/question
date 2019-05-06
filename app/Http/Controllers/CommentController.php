<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function sendConnent(Request $request)
    {
        // コメントの登録処理
        DB::INSERT('INSERT INTO answers_' . $request->id . ' (user_id, user_name, comment) VALUES(:user_id, :user_name, :comment) ',
            [
//                'user_id' => session('twitter_user_id'),
//                'name' => session('name'),
                'user_id' => 1,
                'name' => 'テストユーザ',
                'commnet' => $request->comment
            ]);
    }
}
