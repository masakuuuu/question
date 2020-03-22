<?php

namespace App\Http\Middleware\Question;

use Closure;
use App\Questions;

class CreateQuestionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $form = $request->all();

        // URLハッシュのユニーク値を生成
        while (true) {
            $hash = str_random(32);
            if (!Questions::where('url_hash', $hash)->first()) {
                break;
            }
        }

        // オプションの定数定義
        define('OPTIONS', 
        [
            'is_anyone'=> 1,
            'is_open_view' => 2,
            'is_edit' => 3,
        ]);
        
        // オプション未設定の場合は 空の配列 で初期化する
        if(!isset($form['options'])){
            $form['options'] = [];
        }

        // アンケートテーブルの中身を生成
        $questionArray = [
            'question_title' => $form['question_title'],
            'question_detail' => $form['question_detail'],
            'limit' => $form['limit'],
            'auther_id' => session('twitter_user_id'),
            'auther_name' => session('name'),
            'twitter_id' => session('screen_name'),
            'is_anyone' => in_array(OPTIONS['is_anyone'], $form['options']) ? true : false,
            'is_open_view' => in_array(OPTIONS['is_open_view'], $form['options']) ? true : false,
            'is_edit' => in_array(OPTIONS['is_edit'], $form['options']) ? true : false,
            'edit_password' => isset($form['edit_password']) ? encrypt($form['edit_password']) : null,
            'point' => $form['point'],
            'url_hash' => $hash,
        ];

        // アンケートテーブルの情報をリクエストにマージ
        $request->merge(['questionInfo' => $questionArray]);

        // 選択肢テーブルの中身を生成
        $choiceArray = [];
        foreach ($form['choices'] as $key => $value) {
            // 空文字登録の場合はスキップさせる
            if($value == ""){
                continue;
            }
            array_push($choiceArray, [
                'choice_text' => $value,
            ]);
        }

        // 質問テーブルの情報をリクエストにマージ
        $request->merge(['choiceInfo' => $choiceArray]);

        return $next($request);
    }
}
