<?php

namespace App\Http\Middleware\Auth;

use Closure;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // requestしてきたアクション名をセッションにセット
        session(array(
            // 'redirectUrl' => $_SERVER['REDIRECT_URL'],
            'redirectUrl' => $request->path(),
        ));

        // URLハッシュがある場合はセットする
        if($request->url_hash){
            session(array(
                'url_hash'    => $request->url_hash,
            ));
         }

        // TwitterのOAuth
        $twitterUserId = session('twitter_user_id');
        $name = session('name');
        $screenName = session('screen_name');
        $profileImageUrlHttps = session('profile_image_url_https');

        // twitter認証できていない場合は認証させる
        if (!$twitterUserId && !$name && !$screenName && !$profileImageUrlHttps) {
            return redirect('/OAuth');
        }
        return $next($request);
    }
}
