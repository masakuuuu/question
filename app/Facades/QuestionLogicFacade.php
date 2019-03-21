<?php
/**
 * Created by PhpStorm.
 * User: Masaki
 * Date: 2019/03/02
 * Time: 19:25
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class QuestionLogicFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QuestionLogic';
    }
}