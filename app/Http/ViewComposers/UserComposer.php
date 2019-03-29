<?php
/**
 * Created by PhpStorm.
 * User: Masaki
 * Date: 2019/03/03
 * Time: 21:34
 */

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class UserComposer
{
    /**
     * @var string
     */
    protected $test;

    public function __construct()
    {
        $this->test = 'test!!!!';
    }

    public function compose(View $view)
    {
        $view->with('test', $this->test);
    }

}