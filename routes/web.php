<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Middleware\Question\CreateQuestionMiddleware;
use App\Http\Middleware\Question\EditQuestionMiddleware;
use App\Http\Middleware\Question\ViewQuestionMiddleware;
use App\Http\Middleware\Question\EditChoiceMiddleware;
use App\Http\Middleware\Answer\AnswerMiddleware;
use App\Http\Middleware\Answer\AnswerExeMiddleware;
use App\Http\Middleware\Answer\ViewAnswerMiddleware;
use App\Http\Middleware\Answer\ViewAnswerdUserMiddleware;
use App\Http\Middleware\Comment\SendCommentMiddleware;
use App\Http\Middleware\Auth\AuthMiddleware;

// ユーザ登録画面
Route::get('OAuth','TwitterOAuthController@oAuth');
Route::get('Callback','TwitterOAuthController@callback');

// ログアウト
Route::get('Logout','TwitterOAuthController@logout');

// トップ画面
Route::get('/','HomeController@index');

// アンケートの閲覧画面
Route::get('View','QuestionController@view')->middleware(ViewQuestionMiddleware::class);

// アンケートの画面
Route::get('ViewVoteAnswer','AnswerController@answer')->middleware(AnswerMiddleware::class);

// ゲスト回答画面
Route::get('GestAnswer','AnswerController@answer')->middleware(AnswerMiddleware::class);
Route::post('GestAnswerExe','AnswerController@answerExe')->middleware(AnswerMiddleware::class)->middleware(AnswerExeMiddleware::class);

// アンケート結果確認画面
Route::get('GestViewAnswer','AnswerController@gestViewAnswer')->middleware(ViewAnswerMiddleware::class);

//// アンケート作成画面
//Route::get('Create','QuestionController@create')->middleware(AuthMiddleware::class);
//Route::post('CreateExe','QuestionController@createExe')->middleware(CreateQuestionMiddleware::class);

//// アンケートの再編集
//Route::get('ReEdit','QuestionController@reEdit')->middleware(EditQuestionMiddleware::class)->middleware(EditChoiceMiddleware::class);
//Route::post('ReEditExe','QuestionController@reEditExe')->middleware(CreateQuestionMiddleware::class)->middleware(EditQuestionMiddleware::class)->middleware(EditChoiceMiddleware::class);
//Route::post('CheckEditPassword','QuestionController@checkEditPassword')->middleware(EditQuestionMiddleware::class);

//// アンケート回答画面
//Route::get('Answer','AnswerController@answer')->middleware(AnswerMiddleware::class);
//Route::post('AnswerExe','AnswerController@answerExe')->middleware(AnswerMiddleware::class)->middleware(AnswerExeMiddleware::class);
//Route::get('ViewAnswer','AnswerController@viewAnswer')->middleware(ViewAnswerMiddleware::class);
//Route::post('ViewAnsweredUserList','AnswerController@viewAnsweredUser')->middleware(ViewAnswerdUserMiddleware::class);

//// コメント投稿処理
//Route::post('SendComment','CommentController@sendComment')->middleware(SendCommentMiddleware::class);

// Twitter認証が必要なページ一覧
Route::group(['middleware' => 'auth'], function(){
    // アンケート作成画面
    Route::get('Create','QuestionController@create');
    Route::post('CreateExe','QuestionController@createExe')->middleware(CreateQuestionMiddleware::class);

    // アンケートの再編集
    Route::get('ReEdit','QuestionController@reEdit')->middleware(EditQuestionMiddleware::class)->middleware(EditChoiceMiddleware::class);
    Route::post('ReEditExe','QuestionController@reEditExe')->middleware(CreateQuestionMiddleware::class)->middleware(EditQuestionMiddleware::class)->middleware(EditChoiceMiddleware::class);
    Route::post('CheckEditPassword','QuestionController@checkEditPassword')->middleware(EditQuestionMiddleware::class);

    // アンケート一覧画面
    Route::get('ViewQuestionsList','QuestionController@viewList');

    // アンケート回答画面
    Route::get('Answer','AnswerController@answer')->middleware(AnswerMiddleware::class);
    Route::post('AnswerExe','AnswerController@answerExe')->middleware(AnswerMiddleware::class)->middleware(AnswerExeMiddleware::class);
    Route::get('ViewAnswer','AnswerController@viewAnswer')->middleware(ViewAnswerMiddleware::class);
    Route::post('ViewAnsweredUserList','AnswerController@viewAnsweredUser')->middleware(ViewAnswerdUserMiddleware::class);

    // コメント投稿処理
    Route::post('SendComment','CommentController@sendComment')->middleware(SendCommentMiddleware::class);
});