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
                'choiceInfo' => $request->choiceText,
                'shareUrl' => $request->shareUrl,
            ]
        );
    }

    public function reEdit(Request $request)
    {
        $form = $request->all();
        return view("edit",
            [
                    'oldQuestionInfo' => $form['oldQuestionInfo'],
                    'choiceInfo' => $form['choiceText'],
                    'reEdit' => true
            ]
        );
    }

    public function reEditExe(QuestionRequest $request)
    {
        $form = $request->all();
        Answers::where('question_id', $form['oldQuestionInfo']->id)->delete();
        Choices::where('question_id', $form['oldQuestionInfo']->id)->delete();
        Questions::where('id', $form['oldQuestionInfo']->id)->delete();
        return $this->createExe($request);
    }

    /**
     * 質問データの削除
     */
    public function delete(Request $request)
    {
        $form = $request->all();
        $message = "";
        // 照合に失敗した場合はそのまま元の画面に返す
        if(QuestionLogicFacade::isAuther($form['questionId'], session('twitter_user_id'))){
            if(QuestionLogicFacade::deleteQuestion($form['questionId'], session('twitter_user_id'))){
                $message = "質問情報を削除しました";
            }else{
                $message = "質問情報の削除に失敗しました";
            }
        }else{
            $message = "質問情報の照合に失敗しました";
        }
        return $this->viewList($message);
    }

    public function viewList(String $aMessage = '')
    {
       $questionsList = QuestionLogicFacade::getQuestionsList(session('twitter_user_id'));
       foreach($questionsList as $question){
        $question->limit = date('Y年m月d日', strtotime($question->limit));   
       }
        return view('createList', ['questionsList' => $questionsList, 'message' => $aMessage]);
    }
}
