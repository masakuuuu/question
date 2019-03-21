<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choices extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'question_id' => 'required',
        'choices_id' => 'required',
        'choices_text' => 'required',
    );
}
