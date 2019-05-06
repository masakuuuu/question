<script>
    $(function () {

        $('#point_view').val($('#point').val());
        if($('#is_edit').prop('checked')){
            $('#password_form').show();
        }

        $('#is_edit').on('click', function () {
            $('#password_form').toggle();
        });

        $('#point').on('input', function () {
            $('#point_view').val($('#point').val());
        })

        $('#add').on('click', function()
        {
            $('#choices').trigger('create').append('<div class="uk-form-controls">\n' +
                '                     <input class="uk-input" type="text" name="choices[]"\n' +
                '                            placeholder="Some text...">\n' +
                '                  </div>');
            return false;
        })
    });

</script>

<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">

        <form class="uk-form-stacked uk-margin-large" action="CreateExe" method="post">

            <fieldset class="uk-fieldset uk-width-xlarge">

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach

                {{ csrf_field() }}
                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="title">タイトル</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="title" type="text" name="question_title"
                               value="{{old('question_title')}}">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="detail">概要</label>
                    <div class="uk-form-controls">
                        <textarea id="detail" class="uk-textarea" rows="5" name="question_detail">{{old('question_detail')}}</textarea>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold">選択肢<a href="#"
                                                                    class="uk-margin-left uk-text-small"
                                                                    id = "add"
                                                                    >追加</a></label>
                    <div id="choices">
                        <div class="uk-form-controls">

                            @if(old('choices'))
                                @foreach(old('choices') as $key => $choice)
                                    @if($choice != "")
                                        <input class="uk-input" type="text" name="choices[]"
                                               value="{{$choice}}">
                                    @elseif(count(old('choices')) <= 2)
                                        <input class="uk-input" type="text" name="choices[]">
                                    @endif
                                @endforeach
                            @else
                                <input class="uk-input" type="text" name="choices[]">
                                <input class="uk-input" type="text" name="choices[]">
                            @endif

                        </div>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="point">持ち点</label>
                    <input class="uk-margin-bottom uk-input" type="text" name="point" id="point_view" value="{{old('point')}}">
                    @if(old('point'))
                        <input class="uk-range" id="point" type="range" value="{{old('point')}}" min="1" max="100"
                               step="1">
                    @else
                        <input class="uk-range" id="point" type="range" value="1" min="1" max="100" step="1">
                    @endif
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="autherName">投稿者名</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="autherName" type="text" name="auther_name"
                               value="{{old('auther_name')}}" placeholder="名無しさん">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="limit">締切日</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="limit" type="date" name="limit"
                               value="{{old('limit')}}">
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
                        <input class="uk-input" id="password" type="password" name="password">
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