<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>QuestionApp!</title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.25/css/uikit.min.css" />

    <!-- jQuery is required -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- UIkit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.25/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.25/js/uikit-icons.min.js"></script>

</head>
<body>
<div class="uk-section">
    <div class="uk-section-default">
        <div class="title m-b-md">
            QuestionApp!
            <p>Analyz Complicated Questions</p>
        </div>

        <div class="current_questions">
            受付中
            @if(count($current_questions))
                @foreach($current_questions as $question)
                    <a href="Answer?url_hash={{ $question->url_hash }}">{{ $question->question_title }}</a>
                @endforeach
            @else
                受付中のアンケートがありません
            @endif
        </div>

        <div class="result_questions">
            集計終了
            @if(count($result_questions))
                @foreach($result_questions as $question)
                    <a href="Answer?url_hash={{ $question->url_hash }}">{{ $question->question_title }}</a>
                @endforeach
            @else
                集計が終了しているアンケートがありません
            @endif

        </div>

        <div class="links">
            <a href="#">New</a>
            <a href="#">Hot</a>
            <a href="#">Old</a>
            <a href="Create">cake New Question!</a>
        </div>
    </div>
</div>
</body>
</html>
