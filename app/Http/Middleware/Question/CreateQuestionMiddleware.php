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

        // アンケートテーブルの中身を生成
        $questionArray = [
            'question_title' => $form['question_title'],
            'question_detail' => $form['question_detail'],
            'limit' => $form['limit'],
            'auther_name' => $form['auther_name'],
            'is_open_view' => isset($form['is_open_view']) ? $form['is_open_view'] : true,
            'is_edit' => isset($form['is_edit']) ? $form['is_edit'] : false,
            'edit_password' => isset($form['edit_password']) ? encrypt($form['edit_password']) : null,
            'point' => $form['point'],
            'url_hash' => $hash,
        ];

        // アンケートテーブルの情報をリクエストにマージ
        $request->merge(['questionInfo' => $questionArray]);

        // 選択肢テーブルの中身を生成
        $choiceArray = [];
        foreach ($form['choices'] as $key => $value) {
            array_push($choiceArray, [
                'choice_text' => $value,
            ]);
        }

        // 質問テーブルの情報をリクエストにマージ
        $request->merge(['choiceInfo' => $choiceArray]);

        return $next($request);
    }
}
