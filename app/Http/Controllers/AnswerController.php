<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Facades\QuestionLogicFacade;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;

use App\Facades\AnswerLogicFacade;

class AnswerController extends Controller
{
    /**
     * アンケート回答画面を表示する
     *
     * @param Request $request リクエスト情報（Middlewareで加工された値がセットされています
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function answer(Request $request)
    {
        if ($request->isAnswered || !$request->questionLimit) {
            // 解答済みのアンケートの場合はアンケート結果画面を表示する
            // ログイン済みかどうかをチェック
            if(session('twitter_user_id')){
                return redirect()->action(
                    'AnswerController@viewAnswer', ['url_hash' => $request->url_hash]);
            }else{
                return redirect()->action(
                    'AnswerController@gestViewAnswer', ['url_hash' => $request->url_hash]);
            }

        } else {
            // 未回答の場合はアンケート回答画面を表示する
            return view('answer',
                [
                    'questionInfo' => $request->questionInfo,
                    'choiceInfo' => $request->choiceInfo,
                    'isAnswered' => $request->isAnswered,
                    'msg' => '',
                    'questionLimit' => $request->questionLimit,
                    'isGestAnswer' => $request->isGestAnswer,
                ]
            );
        }
    }

    /**
     * アンケートの回答を登録し、結果画面を表示します。
     *
     * @param AnswerRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function answerExe(AnswerRequest $request)
    {
        // 回答のチェック
        // ①解答済みか
        // ②回答期限内か
        if ($request->isAnswered || !$request->questionLimit) {
            return redirect()->action(
                'AnswerController@viewAnswer', ['url_hash' => $request->url_hash]);
        }

        // 投票数の条件チェック
        if ($request->questionInfo->point != $request->totalVotes) {
            return view('answer',
                [
                    'questionInfo' => $request->questionInfo,
                    'choiceInfo' => $request->choiceInfo,
                    'answerInfo' => $request->answerInfo,
                    'isAnswered' => $request->isAnswered,
                    'msg' => $request->questionInfo->point < $request->totalVotes ? '投票上限数を超えています' : '投票数が不足しています',
                    'questionLimit' => $request->questionLimit,
                ]
            );
        }

        // 選択肢の登録処理
        foreach ($request->answersInfo as $answerInfo) {
            $answerValue['question_id'] = $answerInfo['question_id'];
            $answerValue['choice_id'] = $answerInfo['choice_id'];
            $answerValue['votes'] = $answerInfo['votes'];
            $answerValue['user_id'] = $answerInfo['user_id'];
            $answerValue['user_name'] = $answerInfo['user_name'];
            $answers = new Answers();
            $answers->fill($answerValue)->save();
        }

        if (isset($request->isGestAnswer)) {
            return redirect()->action(
                'AnswerController@gestViewAnswer', ['url_hash' => $request->url_hash]);
        } else {
            return redirect()->action(
                'AnswerController@viewAnswer', ['url_hash' => $request->url_hash]);
        }
    }

    /**
     * アンケート結果画面を表示します。
     *
     * @param Request $request
     */
    public function viewAnswer(Request $request)
    {
        // URLハッシュから質問情報を取得
        $questionInfo = QuestionLogicFacade::getQuestionData($request->url_hash);
        $questionInfo->limit = date('Y年m月d日', strtotime($questionInfo->limit));

        // 投票結果を取得
        $answerInfo = AnswerLogicFacade::getAnswerData($questionInfo->id);

        return view('answerView',
            [
                'isAnswered' => $request->isAnswered,
                'questionInfo' => $questionInfo,
                'answerInfo' => $answerInfo,
                'commentList' => $request->commentList,
                'shareUrl' => $request->shareUrl,
            ]
        );
    }

    /**
     * ゲスト用のアンケート結果画面を表示します。
     *
     * @param Request $request
     */
    public function gestViewAnswer(Request $request)
    {
        // URLハッシュから質問情報を取得
        $questionInfo = QuestionLogicFacade::getQuestionData($request->url_hash);
        $questionInfo->limit = date('Y年m月d日', strtotime($questionInfo->limit));

        // 投票結果を取得
        $answerInfo = AnswerLogicFacade::getAnswerData($questionInfo->id);

        return view('answerView',
            [
                'isAnswered' => $request->isAnswered,
                'questionInfo' => $questionInfo,
                'answerInfo' => $answerInfo,
                'commentList' => $request->commentList,
                'shareUrl' => $request->shareUrl,
            ]
        );
    }

    public function viewAnsweredUser(Request $request){
        return [
            'AnsweredUserData' => $request->answeredUserData
        ];
    }
}
