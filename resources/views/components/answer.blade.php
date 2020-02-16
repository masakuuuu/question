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
        var point = document.getElementById("point");
        var point_view = document.getElementById("point_view");

        if (checkVotes()) {
            var replace_answer_number = Number(answer_num.value) + 1;
            var replace_point_number = Number(point.value) - 1;

            answer_num.value = replace_answer_number;
            answer_view.innerHTML = replace_answer_number;
            point.value = replace_point_number;
            point_view.innerHTML = replace_point_number;
        }
    }

    function subtractVotes(id) {
        var answer_num = document.getElementById("answer_" + id);
        var answer_view = document.getElementById("answer_view_" + id);
        var point = document.getElementById("point");
        var point_view = document.getElementById("point_view");

        if (Number(answer_num.value) > 0) {
            var replace_number = Number(answer_num.value) - 1;
            var replace_point_number = Number(point.value) + 1;

            answer_num.value = replace_number;
            answer_view.innerHTML = replace_number;
            point.value = replace_point_number;
            point_view.innerHTML = replace_point_number;
        }
    }
</script>

<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                        <img class="uk-border-circle" width="40" height="40" src="{{ $questionInfo->thumbnail }}">
                    </div>
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom">{{ $questionInfo->question_title }}</h3>
                        <p class="uk-text-meta uk-margin-remove-top">
                            {{ $questionInfo->auther_name }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p>{{ $questionInfo->question_detail }}</p>
            </div>
            <div class="uk-card-footer">

                @if(session('twitter_user_id'))
                <div class="uk-flex uk-flex-center">
                    <div>
                        <input type="hidden" id="point" value="{{ $questionInfo->point }}">
                        残り <span id="point_view" class="uk-text-bold uk-text-large">{{ $questionInfo->point }}</span> 点
                    </div>
                </div>
                @endif

                    @if(session('twitter_user_id'))
                        <form action="AnswerExe" method="post">
                    @else
                        <form action="Answer" method="get">
                    @endif
                    {{ csrf_field() }}
                    <input type="hidden" name="url_hash" value="{{$questionInfo->url_hash}}">
                    <input type="hidden" name="question_id" value="{{$questionInfo->id}}">

                    <table class="uk-table uk-table-hover uk-table-divider">
                        <thead>
                        <tr>
                            <th>選択肢</th>
                            @if(session('twitter_user_id'))
                            <th>投票ボタン</th>
                            <th>投票数</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($choiceInfo as $choice)
                            <tr>
                                <td>
                                    {{ $choice->choice_text }}
                                </td>
                                @if(session('twitter_user_id'))
                                <td>
                                    <a onclick="addVotes({{$choice->id}})" class="uk-icon-button" uk-icon="plus"></a>
                                    <a onclick="subtractVotes({{$choice->id}})" class="uk-icon-button" uk-icon="minus"></a>
                                </td>
                                <td>
                                    <input type="hidden" name="answers[{{$choice->id}}]" id="answer_{{$choice->id}}"
                                           value="@if(old('answers.' . $choice->id)) {{ old('answers.' . $choice->id) }} @else 0 @endif">
                                    <span id="answer_view_{{$choice->id}}">@if(old('answers.' . $choice->id)) {{ old('answers.' . $choice->id) }} @else
                                            0 @endif</span>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="uk-flex uk-flex-center">
                        <p uk-margin>
                            @if(session('twitter_user_id'))
                                <button class="uk-button uk-button-default uk-width-small" type="submit">回答</button>
                                <button class="uk-button uk-button-default uk-width-small" type="submit">キャンセル</button>
                            @else
                                <button class="uk-button uk-button-default uk-width-small" type="submit">ログインして回答
                                </button>
                            @endif
                        </p>
                    </div>
                </form>
                <p class="uk-text-muted">締切日： {{ $questionInfo->limit }} </p>
            </div>
        </div>
    </div>
</div>