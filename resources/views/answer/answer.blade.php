<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>QuestionApp!</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <script>


        function checkVotes() {
            var choiceTotalNum = 0;
            var votesLimit = {{$questionInfo->point}};

            @foreach($choiceInfo as $choice)
                choiceTotalNum += Number(document.getElementById('answer_{{$choice->id}}').value);
            @endforeach

            if (choiceTotalNum >= votesLimit) {
                return false;
            }
            return true;
        }

        function addVotes(id) {
            var answer_num = document.getElementById("answer_" + id);
            var answer_view = document.getElementById("answer_view_" + id);

            if (checkVotes()) {
                var replace_number = Number(answer_num.value) + 1;

                answer_num.value = replace_number;
                answer_view.innerHTML = replace_number;
            }
        }

        function subtractVotes(id) {
            var answer_num = document.getElementById("answer_" + id);
            var answer_view = document.getElementById("answer_view_" + id);

            if (Number(answer_num.value) > 0) {
                var replace_number = Number(answer_num.value) - 1;

                answer_num.value = replace_number;
                answer_view.innerHTML = replace_number;
            }
        }
    </script>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
        <div class="title">
            {{ $questionInfo->question_title }}
        </div>
        <div class="detail">
            {{$questionInfo->question_detail}}
        </div>
        <div class="auther">
            {{$questionInfo->auther_name}}
        </div>
        <div class="limit">
            {{ $questionInfo->limit }}
        </div>
        <div id="votes">
            @foreach($answerInfo as $answer)
                {{$answer->choice_text}}
                {{$answer->votes}}
                <br>
            @endforeach
        </div>

        @isset($msg)
            {{$msg}}
        @endisset

        @if($isAnswered)
            <div class="answered">
                解答済みのアンケートです
            </div>
        @else

            @if($questionLimit)
                <form action="AnswerExe" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="url_hash" value="{{$questionInfo->url_hash}}">
                    <input type="hidden" name="question_id" value="{{$questionInfo->id}}">
                    @foreach($choiceInfo as $choice)
                        <div class="choices">
                            {{$choice->choice_text}}
                            <input type="hidden" name="answers[{{$choice->id}}]" id="answer_{{$choice->id}}"
                                   value="@if(old('answers.' . $choice->id)) {{ old('answers.' . $choice->id) }} @else 0 @endif">
                            <p id="answer_view_{{$choice->id}}">@if(old('answers.' . $choice->id)) {{ old('answers.' . $choice->id) }} @else
                                    0 @endif</p>
                            <input type="button" onclick="addVotes({{$choice->id}})" value="add">
                            <input type="button" onclick="subtractVotes({{$choice->id}})" value="subtract">
                        </div>
                    @endforeach
                    Your Name: <input type="text" name="user_name">
                    <input type="submit" value="answer!">
                </form>

                    @if($questionInfo->is_edit)
                        <a href="ReEdit?url_hash={{$questionInfo->url_hash}}">再編集</a>
                    @endif

                @else
                <div class="result_question">
                    このアンケートの回答は締め切られました
                </div>
            @endif

        @endif
    </div>
</div>
</body>
</html>
