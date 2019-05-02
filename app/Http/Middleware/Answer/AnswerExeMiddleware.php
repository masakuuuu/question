<?php

namespace App\Http\Middleware\Answer;

use Closure;

class AnswerExeMiddleware
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
        $form = $request->all();

        // 選択肢テーブルの中身を生成
        $answerArray = [];

        // 投票数の合計値の取得
        $totalVotes = 0;
        foreach ($form['answers'] as $choice_id => $votes) {
            // 投票数が1票以上の時だけ登録する
            if($votes > 0){
                array_push($answerArray, [
                    'question_id' => (int)$form['question_id'],
                    'choice_id' => $choice_id,
                    'votes' => (int)$votes,
                    'user_name' => $form['user_name']?$form['user_name']:'名無しさん',
                ]);
                $totalVotes += $votes;
            }
        }

        // 質問テーブルの情報をリクエストにマージ
        $request->merge(['answersInfo' => $answerArray]);
        $request->merge(['totalVotes' => $totalVotes]);

        return $next($request);
    }
}
