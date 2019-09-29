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
        $sql = 'select count(*), t1.id, t1.question_title, t1.question_detail, t1.url_hash, t1.auther_name
                from questions t1
                       inner join answers t2
                                  on t1.id = t2.question_id
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
        return Questions::where('auther_id', $aUserId)->get();
    }

    public function isAuther(int $aQuestionId, String $sessionId){
        $isAuther = false;
        if(Questions::where('id', $aQuestionId)->where('auther_id', $sessionId)->exists()){
            $isAuther = true;
        }
        return $isAuther;
    }
}