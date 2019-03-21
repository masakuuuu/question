<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'auther_name' => 'required',
        'question_title' => 'required',
        'limit' => 'date',
    );
}
