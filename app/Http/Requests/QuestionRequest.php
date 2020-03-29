<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'CreateExe' || $this->path() == 'ReEditExe') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_title' => 'required',
            'question_detail' => 'required',
            'limit' => 'required',
            'point' => 'required|numeric|between:1,100',
            'choiceInfo' => 'min:2',
        ];
    }

    /**
     * オリジナルメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'question_title.required' => 'タイトルを入力してください',
            'question_detail.required' => '概要を入力してください',
            'limit.required' => '締切日を入力してください',
            'point.required' => '投票数を入力してください',
            'point.numeric' => '持ち点は半角数字で入力してください',
            'point.between' => '持ち点は1～100で入力してください',
            'choiceInfo.min' => '選択肢は最低でも２件以上設定してください',
        ];
    }
}
