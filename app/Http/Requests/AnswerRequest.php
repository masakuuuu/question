<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'AnswerExe' || $this->path() == 'GestAnswerExe') {
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
            'answersInfo.*.question_id' => 'required|integer',
            'answersInfo.*.choice_id' => 'required|integer',
            'answersInfo.*.votes.*' => 'required|integer',
            'answer_name' => 'required',
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
            'answersInfo.*.question_id.required' => 'アンケートIDが未指定です',
            'answersInfo.*.question_id.integer' => 'アンケートIDは整数値で入力してください',
            'answersInfo.*.choice_id.required' => '選択肢IDが未指定です',
            'answersInfo.*.choice_id.integer' => '選択肢IDは整数値で入力してください',
            'answersInfo.*.votes.required' => '投票数を入力してください',
            'answersInfo.*.votes.integer' => '投票数は整数値で入力してください',
            'answer_name.required' => '回答者名を入力してください',
        ];
    }
}
