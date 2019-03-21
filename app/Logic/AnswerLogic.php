<?php
/**
 * Created by PhpStorm.
 * User: Masaki
 * Date: 2019/03/02
 * Time: 19:05
 */

namespace App\Logic;

use App\Answers;
use App\Choices;
use App\Questions;
use Illuminate\Support\Facades\DB;

/**
 * Class AnswerLogic
 *
 * 質問データに関するロジックを定義するクラス
 *
 * @package App\Logic
 */
class AnswerLogic
{
    /**
     * 質問テーブルのURLハッシュ値からアンケートデータを１件取得します
     *
     * @param String $aUrl_hash URLハッシュ値
     * @return mixed 質問データ
     */
    public function getQuestionData(String $aUrl_hash)
    {
        return Questions::where('url_hash', $aUrl_hash)->first();
    }

    /**
     * 選択肢テーブルから選択肢データを取得します
     *
     * @param int 質問ID
     * @return mixed 選択肢データ
     */
    public function getChoiceData(int $aQuestionId)
    {
        return Choices::where('question_id', $aQuestionId)->get();
    }

    /**
     * 投票結果データを取得します
     *
     * @param int 質問ID
     * @return mixed 投票結果データ
     */
    public function getAnswerData(int $aQuestionId)
    {
        // 投票結果を取得
        $param = ['question_id' => $aQuestionId];
        return DB::select('
              SELECT foo.choice_id, foo.choice_text, COALESCE(foo.votes, 0) AS votes FROM (
                  SELECT t1.id AS choice_id, MAX(t1.choice_text) AS choice_text, SUM(t2.votes) AS votes FROM choices t1 LEFT OUTER JOIN answers t2 ON t1.id = t2.choice_id WHERE t1.question_id = :question_id GROUP BY t1.id
              ) AS foo;', $param);

    }

    /**
     * アンケートの回答期限が過ぎていないかをチェックします
     *
     * @param String $aUrl_hash　URLハッシュ値
     * @return bool 回答可能かどうか
     */
    public function checkQuestionLimit(String $aUrl_hash){
        if(Questions::where('url_hash', $aUrl_hash)->where('limit', '>', date("Y-m-d"))->get()->first()){
            return true;
        }
        return false;
    }

    /**
     * アンケートが既に解答済みかどうかをチェック
     * セッションIDでチェックしているため、二重チェックは甘いです。
     * 今後はTwitter連携のユーザのみ利用可能や、アプリ用のアカウント作成後にしか解答できないとする
     *
     * @param Integer $aQuestionId 質問ID
     * @param String $sessionId セッションID
     * @return bool 解答済みかどうか
     */
    public function isAnswered(int $aQuestionId, String $sessionId): bool
    {
        $isAnswered = false;
        if (Answers::where('question_id', $aQuestionId)->where('user_id', $sessionId)->exists()) {
            $isAnswered = true;
        }
        return $isAnswered;

    }

}