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

<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                        <img class="uk-border-circle" width="40" height="40" src="images/avatar.jpg">
                    </div>
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom">{{ $questionInfo->question_title }}</h3>
                        <p class="uk-text-meta uk-margin-remove-top">
                            by {{ $questionInfo->auther_name }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p>{{ $questionInfo->question_detail }}</p>
            </div>
            <div class="uk-card-footer">

                <form action="AnswerExe" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="url_hash" value="{{$questionInfo->url_hash}}">
                    <input type="hidden" name="question_id" value="{{$questionInfo->id}}">

                    <table class="uk-table uk-table-hover uk-table-divider">
                        <thead>
                        <tr>
                            <th>選択肢</th>
                            <th>投票ボタン</th>
                            <th>投票数</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($choiceInfo as $choice)
                            <tr>
                                <td>
                                    {{ $choice->choice_text }}
                                </td>
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="uk-margin" id="password_form" style="display: none">
                        <label class="uk-form-label uk-text-bold" for="password">お名前</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="user_name" type="text" name="user_name" placeholder="Some text...">
                        </div>
                    </div>

                    <div class="uk-flex uk-flex-center">
                        <p uk-margin>
                            <button class="uk-button uk-button-default uk-width-small" type="submit">投票</button>
                            <button class="uk-button uk-button-default uk-width-small" type="submit">キャンセル</button>
                        </p>
                    </div>
                </form>
                <p class="uk-text-muted">締切日： {{ $questionInfo->limit }} </p>
            </div>
        </div>
    </div>
</div>