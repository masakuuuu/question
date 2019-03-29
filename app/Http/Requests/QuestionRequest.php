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
//            'auther_name' => 'required',
            'question_title' => 'required',
            'question_detail' => 'required',
            'choices.*' => 'required',
            'edit_password' => 'required_with:is_edit',
            'limit' => 'required',
            'point' => 'required|numeric|between:1,100',
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
//            'auther_name.required' => '投稿者名を入力してください',
            'question_title.required' => 'タイトルを入力してください',
            'question_detail.required' => '概要を入力してください',
            'choices.*.required' => '選択肢を入力してください',
            'limit.required' => '締切日を入力してください',
            'edit_password.required_with' => '編集用パスワードを入力してください',
            'point.required' => '投票数を入力してください',
            'point.numeric' => '投票数は半角数字で入力してください',
            'point.between' => '投票数は1～100で入力してください',
        ];
    }
}
