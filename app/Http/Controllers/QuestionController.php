<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Facades\QuestionLogicFacade;
use App\Questions;
use App\Choices;
use App\Http\Requests\QuestionRequest;
use App\Http\Requests\ReEditQuestionRequest;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use App\Facades\AnswerLogicFacade;
use Illuminate\Support\Facades\Schema;

class QuestionController extends Controller
{
    public function create()
    {
        return view("create");
    }

    public function createExe(QuestionRequest $request)
    {
        // アンケートの登録処理
        $questions = new Questions;
        $questions->fill($request->questionInfo)->save();

        // 選択肢の登録処理
        foreach ($request->choiceInfo as $choiceValue) {
            $choiceValue['question_id'] = $questions->id;
            $question = new Choices;
            $question->fill($choiceValue)->save();
        }

        // アンケートテーブルとコメントテーブルの作成
        AnswerLogicFacade::createAnswerTable($questions->id);

        // URLハッシュから質問情報を取得
        $questionInfo = QuestionLogicFacade::getQuestionData($request->questionInfo['url_hash']);

        $questionInfo->limit = date('Y年m月d日', strtotime($questionInfo->limit));


        // 質問iDをキーにして選択肢情報を取得
        $choiceInfo = AnswerLogicFacade::getChoiceData($questionInfo->id);

        // アンケートの表示
//        return view("questionView",
//            [
//                'questionInfo' => $questionInfo,
//                'choiceInfo' => $choiceInfo,
//                'commentList' => array(),
//            ]
//        );

        return redirect()->action(
            'AnswerController@viewAnswer', ['url_hash' => $request->questionInfo['url_hash']]);
    }

    public function view(Request $request)
    {
        // アンケートの表示
        return view("questionView",
            [
                'questionInfo' => $request->questionInfo,
                'choiceInfo' => $request->choiceInfo,
                'shareUrl' => $request->shareUrl,
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

    public function viewList()
    {
        return view('createList', ['questionsList' => QuestionLogicFacade::getQuestionsList(session('twitter_user_id'))]);
    }
}
