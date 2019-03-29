<?php
/**
 * Created by PhpStorm.
 * User: Masaki
 * Date: 2019/03/28
 * Time: 23:28
 */

namespace App\Logic;

use Illuminate\Support\Facades\DB;
use App\User;
class UserLogic
{
    /**
     * ツイッターのユーザ情報を登録する
     *
     * @param int $aUserId    ID
     * @param string $aName   アカウント名
     */
    public function insertTwitterUserData(int $aUserId, string $aName)
    {
        $user = new User;
        $userInfo = [
            'twitter_id' => $aUserId,
            'name' => $aName
        ];
        $user->fill($userInfo)->save();
    }

    /**
     * ツイッターのユーザ情報を更新する
     *
     * @param int $aUserId    ID
     * @param string $aName   アカウント名
     */
    public function updateTwitterUserData(string $aUserId, string $aName){
        $userInfo = [
            'twitter_id' => $aUserId,
            'name' => $aName
        ];
        User::updateOrCreate(['twitter_id' => $aUserId], $userInfo);
    }
}