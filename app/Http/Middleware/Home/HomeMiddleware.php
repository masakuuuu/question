<?php

namespace App\Http\Middleware\Home;

use Closure;
use App\Questions;

class HomeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 公開フラグが True のアンケートのみを取得
//        $request->merge(['questions' => Questions::where('is_open_view', true)->get()]);
        return $next($request);
    }
}
