<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="token" content="{{ csrf_token() }}">
    <title>QuestionApp!</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

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
        function addChoices() {
            var input_element = document.createElement("input");
            input_element.type = "text";
            input_element.name = "choices[]";
            var parent_object = document.getElementById("choices");
            parent_object.appendChild(input_element);
        }

        function reEditConfirm(){
            if(window.confirm('再編集すると集計結果がリセットされます。\nよろしいですか？')){
                return true;
            }else{
                return false
            }
        }

        $(function(){
            // Ajax button click
            $('#reEdit').on('click',function(){
                if(reEditConfirm()){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url:'CheckEditPassword',
                        type:'POST',
                        data:{
                            're_edit_password':$('#re_edit_password').val(),
                            'url_hash':$('#url_hash').val()
                        }
                    })
                    // Ajaxリクエストが成功した時発動
                        .done( (data) => {
                            console.log(data);
                            if(data.result){
                                document.ReEditExe.submit();
                            }else{
                                alert('パスワードが違います');
                            }

                        })
                        // Ajaxリクエストが失敗した時発動
                        .fail( (data) => {
                            alert('パスワード認証に失敗しました');
                        })
                        // Ajaxリクエストが成功・失敗どちらでも発動
                        .always( (data) => {

                        });
                }
            });
        });

    </script>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
        <form action="ReEditExe" method="post" name="ReEditExe">
            {{ csrf_field() }}
            <input type="hidden" name="url_hash" id="url_hash" value="{{$oldQuestionInfo->url_hash}}">
            <div id="title">
                Title :<input type="text" name="question_title" value="{{old('question_title', $oldQuestionInfo->question_title)}}">
            </div>
            <div id="detail">
                Detail : <input type="textarea" name="question_detail" value="{{old('question_detail', $oldQuestionInfo->question_detail)}}">
            </div>
            <div id="choices">
                Question : <br>
                @if(old('choices', $choiceText))
                    @foreach(old('choices', $choiceText) as $key => $choice)
                        <input type="text" name="choices[]" value="{{$choice}}"><br>
                    @endforeach
                @else
                    <input type="text" name="choices[]" value=""><br>
                @endif
                <input type="button" value="add" onclick="addChoices()">
            </div>
            <div id="auther_name">
                Detail : <input type="text" name="auther_name" value="{{ old('auther_name', $oldQuestionInfo->auther_name) }}">
            </div>
            <div id="limit">
                Limit : <input type="date" name="limit" value="{{old('limit', $oldQuestionInfo->limit)}}">
            </div>
            <input type="checkbox" name="is_open_view" value="1" @if(old('is_open_view', $oldQuestionInfo->is_open_view) == 1) checked @endif>is open view<br>
            <input type="checkbox" name="is_edit" value="1" @if(old('is_edit', $oldQuestionInfo->is_edit) == 1) checked @endif>is edit<br>
            PASS : <input type="password" name="edit_password"><br>
            Point : <input type="text" name="point" value="{{ old('point', $oldQuestionInfo->point) }}"><br>

            ReEditPASS : <input type="password" name="re_edit_password" id="re_edit_password"><br>
            <div id="submit">
                <input type="button" value="Create!" id="reEdit">
            </div>
        </form>
    </div>
</div>
</body>
</html>
