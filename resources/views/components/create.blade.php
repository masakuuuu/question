<script>
    $(function () {
        $('#is_edit').on('click', function () {
            $('#password_form').toggle();
        });

        $('#point').on('input', function () {
            $('#point_view').text($('#point').val());
        })
    });

    function addChoices() {
        $('#choices').trigger('create').append('<div class="uk-form-controls">\n' +
            '                     <input class="uk-input" type="text" name="choices[]"\n' +
            '                            placeholder="Some text...">\n' +
            '                  </div>');
    }
</script>

<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">

        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach

        <form class="uk-form-stacked uk-margin-large" action="CreateExe" method="post">

            <fieldset class="uk-fieldset uk-width-xlarge">

                {{ csrf_field() }}
                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="title">タイトル</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="title" type="text" name="question_title"
                               value="{{old('question_title')}}" placeholder="Some text...">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="detail">概要</label>
                    <div class="uk-form-controls">
                        <textarea id="detail" class="uk-textarea" rows="5" placeholder="Textarea" name="question_detail"
                                  value="{{old('question_detail')}}"></textarea>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold">選択肢<a href="#"
                                                                    class="uk-margin-left uk-text-small"
                                                                    onclick="addChoices()">追加</a></label>
                    <div id="choices">
                        <div class="uk-form-controls">
                            <input class="uk-input" type="text" name="choices[]"
                                   value="{{old('choices[]')}}" placeholder="Some text...">
                        </div>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="point">持ち点</label>
                    <p id="point_view">1</p>
                    <input class="uk-range" id="point" type="range" value="1" min="1" max="100" step="1"
                           name="point" value="{{old('point')}}">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="autherName">投稿者名</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="autherName" type="text" name="auther_name"
                               value="{{old('auther_name')}}" placeholder="Some text...">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="limit">回答期限</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="limit" type="date" name="limit"
                               value="{{old('limit')}}" placeholder="Some text...">
                    </div>
                </div>

                <div class="uk-margin">
                    <div class="uk-form-label uk-text-bold">オプション</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-checkbox" type="checkbox" name="is_open_view" value="1"
                                      @if(old('is_open_view')) @if(old('is_open_view') == 1) checked
                                      @endif @else checked @endif> 一般公開</label><br>
                        <label><input class="uk-checkbox" type="checkbox" id="is_edit" name="is_edit" value="1"
                                      @if(old('is_edit') == 1) checked @endif> 編集可能</label>
                    </div>
                </div>

                <div class="uk-margin" id="password_form" style="display: none">
                    <label class="uk-form-label uk-text-bold" for="password">編集パスワード</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="password" type="password" name="password"
                               placeholder="Some text...">
                    </div>
                </div>

                <div class="uk-flex uk-flex-center">
                    <p uk-margin>
                        <button class="uk-button uk-button-default uk-width-small" type="submit">作成</button>
                        <button class="uk-button uk-button-default uk-width-small" type="submit">一時保存</button>
                        <button class="uk-button uk-button-default uk-width-small" type="submit">キャンセル</button>
                    </p>
                </div>

            </fieldset>

        </form>

    </div>
</div>