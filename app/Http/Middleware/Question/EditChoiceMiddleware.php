<?php

namespace App\Http\Middleware\Question;

use Closure;
use App\Choices;

class EditChoiceMiddleware
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
        $form = $request->all();
        $choiceText = [];
        $choiceInfo = Choices::where('question_id', $form['oldQuestionInfo']->id)->get(['choice_text']);
        foreach($choiceInfo as $choice){
            array_push($choiceText, $choice->choice_text);
        }

        $request->merge(['choiceText' => $choiceText]);
        return $next($request);
    }
}
