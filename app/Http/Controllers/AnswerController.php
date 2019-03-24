<?php

namespace App\Http\Controllers;

use App\Answers;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use App\Http\Requests\ViewAnsweredUserRequest;

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
        if ($request->isAnswered) {
            // 解答済みのアンケートの場合はアンケート結果画面を表示する
            return $this->viewAnswer($request);
        } else {
            // 未回答の場合はアンケート回答画面を表示する
            return view('answer',
                [
                    'questionInfo' => $request->questionInfo,
                    'choiceInfo' => $request->choiceInfo,
                    'isAnswered' => $request->isAnswered,
                    'msg' => '',
                    'questionLimit' => $request->questionLimit,
                ]
            );
        }
    }

    /**
     * アンケート回答画面を表示します。
     *
     * @param AnswerRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function answerExe(AnswerRequest $request)
    {
        // 回答済みチェック
        // 解答済みのアンケートの場合はアンケート結果画面を表示する
        if ($request->isAnswered) {
            return $this->viewAnswer($request);
        }

        // 回答期限チェック
        if (!$request->questionLimit) {
            return $this->answer($request);
        }

        // 投票数の条件チェック
        if ($request->questionInfo->point != $request->totalVotes) {
            return view('answer.answer',
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
            $answerValue['user_id'] = $request->session()->getId();
            $answerValue['user_name'] = $answerInfo['user_name'];
            $answers = new Answers();
            $answers->fill($answerValue)->save();
        }

        return $this->viewAnswer($request);
    }

    /**
     * アンケート結果画面を表示します。
     *
     * @param Request $request
     */
    public function viewAnswer(Request $request)
    {
        // URLハッシュから質問情報を取得
        $questionInfo = AnswerLogicFacade::getQuestionData($request->url_hash);
        $questionInfo['limit'] = date('Y年m月d日', strtotime($questionInfo['limit']));

        // 投票結果を取得
        $answerInfo = AnswerLogicFacade::getAnswerData($questionInfo->id);

        return view('answerView',
            [
                'questionInfo' => $questionInfo,
                'answerInfo' => $answerInfo
            ]
        );
    }

    public function viewAnsweredUser(Request $request){
        return [
            'AnsweredUserData' => $request->answeredUserData
        ];
    }
}
