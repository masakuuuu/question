<?php

namespace App\Http\Middleware\Answer;

use Closure;
use App\Facades\AnswerLogicFacade;

class ViewAnswerdUserMiddleware
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
        // 解答済みユーザデータの取得
        $answeredUserData = AnswerLogicFacade::getAnsweredUserData($request->choice_id);

        $request->merge(['answeredUserData' => $answeredUserData]);

        return $next($request);
    }
}
