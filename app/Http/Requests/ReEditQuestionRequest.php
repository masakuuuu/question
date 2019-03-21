<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReEditQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'CheckEditPassword') {
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
            're_edit_password' => 'required',
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
            're_edit_password.required' => '編集用パスワードを入力してください',
        ];
    }
}
