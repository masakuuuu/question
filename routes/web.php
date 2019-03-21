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

// トップ画面
Route::get('/','HomeController@index');

// アンケート作成画面
Route::get('Create','QuestionController@create');
Route::post('CreateExe','QuestionController@createExe')->middleware(CreateQuestionMiddleware::class);

// アンケートの再編集
Route::get('ReEdit','QuestionController@reEdit')->middleware(EditQuestionMiddleware::class)->middleware(EditChoiceMiddleware::class);
Route::post('ReEditExe','QuestionController@reEditExe')->middleware(CreateQuestionMiddleware::class)->middleware(EditQuestionMiddleware::class)->middleware(EditChoiceMiddleware::class);
Route::post('CheckEditPassword','QuestionController@checkEditPassword')->middleware(EditQuestionMiddleware::class);

// アンケートの閲覧画面
Route::get('View','QuestionController@view')->middleware(ViewQuestionMiddleware::class);

// アンケート回答画面
Route::get('Answer','AnswerController@answer')->middleware(AnswerMiddleware::class);
Route::post('AnswerExe','AnswerController@answerExe')->middleware(AnswerMiddleware::class)->middleware(AnswerExeMiddleware::class);
