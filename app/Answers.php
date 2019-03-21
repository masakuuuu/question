<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'question_id' => 'required',
        'choices_id' => 'required',
        'votes' => 'required',
        'user_id' => 'required',
    );

    protected $casts = [
        'activated' => 'boolean',
        'question_id' => 'integer',
        'choice_id' => 'integer',
        'votes' => 'integer',
    ];
}
