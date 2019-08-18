<?php

namespace App\Http\Controllers;

use App\Facades\UserLogicFacade;
use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterOAuthController extends Controller
{
    public function oAuth(Request $request)
    {
        $twitter = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret')
        );
        // 認証用のrequest_tokenを取得
        #//このとき認証後、遷移する画面のURLを渡す
        $token = $twitter->oauth('oauth/request_token', array(
            'oauth_callback' => config('twitter.callback_url')
        ));

        // 認証画面で認証を行うためSessionに入れる
        session(array(
            'oauth_token' => $token['oauth_token'],
            'oauth_token_secret' => $token['oauth_token_secret'],
        ));

        // 認証画面へ移動させる
        $url = $twitter->url('oauth/authenticate', array(
            'oauth_token' => $token['oauth_token']
        ));

        // ログインを実行した際の画面のリファラ情報をセット
        session(array(
            'redirectUrl' => url()->previous(),
        ));

        return redirect($url);
    }

    public function callback(Request $request)
    {
        $oauth_token = session('oauth_token');
        $oauth_token_secret = session('oauth_token_secret');

        // request_tokenが不正な値だった場合エラー
        if ($request->has('oauth_token') && $oauth_token !== $request->oauth_token) {
            return Redirect::to('/login');
        }

        // request_tokenからaccess_tokenを取得
        $twitter = new TwitterOAuth(
            $oauth_token,
            $oauth_token_secret
        );
        $token = $twitter->oauth('oauth/access_token', array(
            'oauth_verifier' => $request->oauth_verifier,
            'oauth_token' => $request->oauth_token,
        ));

        // access_tokenを用いればユーザー情報へアクセスできるため、それを用いてTwitterOAuthをinstance化
        $twitter_user = new TwitterOAuth(
            config('twitter.consumer_key'),
            config('twitter.consumer_secret'),
            $token['oauth_token'],
            $token['oauth_token_secret']
        );

        // 本来はアカウント有効状態を確認するためのものですが、プロフィール取得にも使用可能
        $twitter_user_info = $twitter_user->get('account/verify_credentials');
        session(array(
            'twitter_user_id' => $twitter_user_info->id,
            'name' => $twitter_user_info->name,
            'screen_name' => $twitter_user_info->screen_name,
            'profile_image_url_https' => $twitter_user_info->profile_image_url_https,
        ));

        UserLogicFacade::updateTwitterUserData($twitter_user_info->id, $twitter_user_info->screen_name, $twitter_user_info->profile_image_url);

        return redirect(session('redirectUrl') ? session('redirectUrl') : '/');
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
