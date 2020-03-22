<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->path() == 'SendComment') {
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
            'comment_name' => 'required',
            'comment' => 'required',
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
            'comment_name.required' => '投稿者名を入力してください',
            'comment.required' => 'コメントを入力してください',
        ];
    }
}
