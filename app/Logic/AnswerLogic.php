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
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Void_;

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
              SELECT answer_result.choice_id, answer_result.choice_text, COALESCE(answer_result.votes, 0) AS votes ,answer_result.user_count
FROM (
       SELECT t1.id AS choice_id, MAX(t1.choice_text) AS choice_text, SUM(t2.votes) AS votes ,count(t2.user_id) AS user_count
       FROM choices t1
              LEFT OUTER JOIN answers t2 ON t1.id = t2.choice_id
       WHERE t1.question_id = :question_id
       GROUP BY t1.id
     ) AS answer_result;', $param);

    }

    /**
     * 選択肢IDから回答済みユーザのデータを取得します
     *
     * @param int $aChoiceId 選択肢ID
     * @return mixed 解答済みデータ
     */
    public function getAnsweredUserData(int $aChoiceId)
    {
        return Answers::where('choice_id', $aChoiceId)->get();
    }

    /**
     * アンケートの回答期限が過ぎていないかをチェックします
     *
     * @param String $aUrl_hash　URLハッシュ値
     * @return bool 回答可能かどうか
     */
    public function checkQuestionLimit(String $aUrl_hash)
    {
        if (Questions::where('url_hash', $aUrl_hash)->where('limit', '>', date("Y-m-d"))->get()->first()) {
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

    /**
     * アンケートの回答者数を取得します
     *
     * @param int $aQuestionId 質問ID
     * @return int 回答者数
     */
    public function getAnseredUserNum(int $aQuestionId): int
    {
        $answerInfo = DB::select('SELECT COUNT(DISTINCT(user_id)) AS user_uum FROM answers WHERE question_id = ;id', ['id' => $aQuestionId]);
        return $answerInfo['user_num'];
    }

    /**
     * アンケート回答用テーブルとコメントテーブルを作成します
     * テーブル名は質問IDで分割します
     *
     * @param int $aQuestionId 質問ID
     */
    public function createAnswerTable(int $aQuestionId): void
    {
        // 回答テーブルの作成
        Schema::create('answers_' . $aQuestionId, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('choice_id');
            $table->integer('votes')->default(0);
            $table->string('user_id');
            $table->text('user_name')->default('No-Name');
            $table->foreign('choice_id')->references('id')->on('choices');
            $table->timestamps();
        });

        // コメントテーブルの作成
        Schema::create('comment_' . $aQuestionId, function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->text('user_name')->default('No-Name');
            $table->text('comment');
            $table->timestamps();
        });
    }
}