<?php

namespace App\Http\Controllers;

use App\Answers;
use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;

use App\Facades\AnswerLogicFacade;

class AnswerController extends Controller
{
    public function answer(Request $request)
    {
        return view('answer',
            [
                'questionInfo' => $request->questionInfo,
                'choiceInfo' => $request->choiceInfo,
                'answerInfo' => $request->answerInfo,
                'isAnswered' => $request->isAnswered,
                'msg' => '',
                'questionLimit' => $request->questionLimit,
            ]
        );
    }

    public function answerExe(AnswerRequest $request)
    {
        // 回答済みチェック
        if ($request->isAnswered) {
            return $this->answer($request);
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
                    'msg' => $request->questionInfo->point < $request->totalVotes?'投票上限数を超えています':'投票数が不足しています',
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

        return view('answer.answerComplete');
    }
}
