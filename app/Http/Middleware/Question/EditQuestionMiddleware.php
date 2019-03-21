<?php

namespace App\Http\Middleware\Question;

use App\Questions;
use Closure;

class EditQuestionMiddleware
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
        $form = $request->all();
        $request->merge(['oldQuestionInfo' => Questions::where('is_edit', true)->where('url_hash', $form['url_hash'])->first()]);

        return $next($request);
    }
}
