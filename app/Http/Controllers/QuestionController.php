<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Questions;
use App\Choices;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\ReEditQuestionRequest;
use Illuminate\Http\Request;
use App\Facades\AnswerLogicFacade;

class QuestionController extends Controller
{
    public function create()
    {
        return view("create");
    }

    public function createExe(QuestionRequest $request)
    {
        // アンケートの登録処理

        // 編集可能状態の場合はパスワードの入力チェック
        if ($request->questionInfo['is_edit']) {
            if (!$request->questionInfo['edit_password']) {
                return view("question.create", ['msg' => '編集用パスワードを入力してください']);
            }
        }
        $questions = new Questions;
        $questions->fill($request->questionInfo)->save();

        // 選択肢の登録処理
        foreach ($request->choiceInfo as $choiceValue) {
            $choiceValue['question_id'] = $questions->id;
            $question = new Choices;
            $question->fill($choiceValue)->save();
        }

        // URLハッシュから質問情報を取得
        $questionInfo = AnswerLogicFacade::getQuestionData($request->questionInfo['url_hash']);

        $questionInfo['limit'] = date('Y年m月d日', strtotime($questionInfo['limit']));


        // 質問iDをキーにして選択肢情報を取得
        $choiceInfo = AnswerLogicFacade::getChoiceData($questionInfo->id);

        // アンケートの表示
        return view("questionView",
            [
                'questionInfo' => $questionInfo,
                'choiceInfo' => $choiceInfo
            ]
        );
    }

    public function view(Request $request)
    {
        // アンケートの表示
        return view("questionView",
            [
                'questionInfo' => $request->questionInfo,
                'choiceInfo' => $request->choiceInfo
            ]
        );
    }

    public function reEdit(Request $request)
    {
        $form = $request->all();
        return view("question.edit", ['oldQuestionInfo' => $form['oldQuestionInfo'], 'choiceText' => $form['choiceText'], 'reEdit' => true]);
    }

    public function reEditExe(QuestionRequest $request)
    {
        $form = $request->all();
        // パスワードが正しければ元のアンケートを削除して新しいものを登録します
        if ($form['edit_password'] == decrypt($form['oldQuestionInfo']->edit_password)) {
            Answers::where('question_id', $form['oldQuestionInfo']->id)->delete();
            Choices::where('question_id', $form['oldQuestionInfo']->id)->delete();
            Questions::where('id', $form['oldQuestionInfo']->id)->delete();
            return $this->createExe($request);
        }
        return view("question.edit", ['msg' => 'パスワードが違います', 'oldQuestionInfo' => $form['oldQuestionInfo'], 'choiceText' => $form['choiceText'], 'reEdit' => true]);
    }

    public function checkEditPassword(ReEditQuestionRequest $request)
    {
        $form = $request->all();
        if ($form['re_edit_password'] == decrypt($form['oldQuestionInfo']->edit_password)) {
            return ['result' => true];
        }
        return ['result' => false];
    }
}
