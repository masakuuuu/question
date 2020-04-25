<?php
/**
 * Created by PhpStorm.
 * User: Masaki
 * Date: 2019/03/16
 * Time: 0:19
 */

namespace App\Logic;

use App\Choices;
use Illuminate\Support\Facades\DB;
use App\Questions;
use Illuminate\Support\Facades\Schema;

/**
 * Class QuestionLogic
 *
 * アンケートデータに関するロジックを定義するクラス
 *
 * @package App\Logic
 */
class QuestionLogic
{
    /**
     * 質問テーブルのURLハッシュ値からアンケートデータを１件取得します
     *
     * @param String $aUrl_hash URLハッシュ値
     * @return mixed 質問データ
     */
    public function getQuestionData(String $aUrl_hash)
    {
        $param = ['url_hash' => $aUrl_hash];
        $questionData = DB::select('SELECT t1.id, t1.auther_name, t1.question_title, t1.question_detail, t1.limit, t1.url_hash, t1.enable,t1.is_anyone , t1.is_open_view, t1.is_edit, t1.point, t2.thumbnail, t2.name FROM questions t1 INNER JOIN users t2 ON t1.auther_id = t2.twitter_id WHERE t1.url_hash = :url_hash limit 1', $param);
        return $questionData[0];

//        return Questions::where('url_hash', $aUrl_hash)->first();
    }

    /**
     * 急上昇アンケートデータを取得します
     * 単位時間あたりに回答者数が多いアンケートを順にソートして返します。
     * 単位時間：1日,3日,5日
     *
     * @return mixed アンケートデータ
     */
    public function getHotQuestionData()
    {
        $questionCount = [];
        $param = [];
        $sql = 'select count(*), t1.id, t1.question_title, t1.question_detail, t1.url_hash, t1.auther_name, max(t3.thumbnail) as thumbnail
                from questions t1
                       inner join answers t2
                                  on t1.id = t2.question_id
                                  inner join users t3 on t1.auther_id = t3.twitter_id
                where t2.created_at > current_date - 1 and t1.limit > current_date and t1.enable
                group by t1.id
                order by count';

        while (true) {
            $marginDay = 1;
            $param = ['marginDay' => (int)$marginDay];
            $questionData = DB::select($sql);
            if (count($questionData) >= 5) {
                break;
            }

            $sql = 'select count(*), t1.id, t1.question_title, t1.question_detail, t1.url_hash, t1.auther_name, max(t3.thumbnail) as thumbnail
                from questions t1
                       inner join answers t2
                                  on t1.id = t2.question_id
                                  inner join users t3 on t1.auther_id = t3.twitter_id
                where t1.limit > current_date and t1.enable
                group by t1.id
                order by count';
            $questionData = DB::select($sql);
            break;
        }
        return $questionData;
    }

    /**
     * ユーザIDに基づく質問のリストを返す
     *
     * @param String  $aUserId ユーザID
     * @return mixed  ユーザに紐づく質問のリスト
     */
    public function getQuestionsList(String $aUserId){
        return Questions::where('auther_id', $aUserId)->orderBy('id', 'desc')->paginate(10);;
    }

    /**
     * 投稿者かどうかをチェックする
     * 
     * @param int    $aQuestionId 質問ID
     * @param String $aSessionId  セッションID
     */
    public function isAuther(int $aQuestionId, String $aSessionId){
        $isAuther = false;
        if(Questions::where('id', $aQuestionId)->where('auther_id', $aSessionId)->exists()){
            $isAuther = true;
        }
        return $isAuther;
    }

    /**
     * 質問データを策書する
     * 質問に紐づく回答データやコメントのデータも削除します
     * 
     * @param int    $aQuestionId 質問ID
     * @param String $aSessionId  セッションID
     */
    public function deleteQuestion(int $aQuestionId, String $aSessionId) : bool
    {
        $result = false;
        DB::beginTransaction();
        try {
            Schema::drop('comment_' . $aQuestionId);
            Schema::drop('answers_' . $aQuestionId);
            Choices::where('question_id', $aQuestionId)->delete();
            Questions::where('id', $aQuestionId)->delete();
            DB::commit();
            $result = true;
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $result;
    }
}