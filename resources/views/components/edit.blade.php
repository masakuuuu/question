<script>
    $(function () {

        $('#point_view').val($('#point').val());

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

        var today = new Date();
        today.setDate(today.getDate() + 3); // 3日後の日付をセットする
        var yyyy = today.getFullYear();
        var mm = ("0"+(today.getMonth()+1)).slice(-2);
        var dd = ("0"+today.getDate()).slice(-2);
        $('#limit').val(yyyy+'-'+mm+'-'+dd);
    });

</script>

<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">

        <form class="uk-form-stacked uk-margin-large" action="ReEditExe" method="post">

            <input type="hidden" name="url_hash" value="{{$oldQuestionInfo->url_hash}}">

            @foreach($errors->all() as $error)
                <div class="uk-text-warning">{{ $error }}</div>
            @endforeach

            <fieldset class="uk-fieldset uk-width-xlarge">

                {{ csrf_field() }}
                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="title">タイトル</label>
                    <div class="uk-form-controls">
                        @if(old('question_title'))
                        <input class="uk-input" id="title" type="text" name="question_title"
                               value="{{old('question_title')}}">
                        @else
                        <input class="uk-input" id="title" type="text" name="question_title"
                               value="{{ $oldQuestionInfo->question_title }} ">
                        @endif
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="detail">概要</label>
                    <div class="uk-form-controls">
                    @if(old('question_detail'))
                        <textarea id="detail" class="uk-textarea" rows="5" name="question_detail">{{old('question_detail')}}</textarea>
                    @else
                        <textarea id="detail" class="uk-textarea" rows="5" name="question_detail">{{$oldQuestionInfo->question_detail}}</textarea>
                    @endif
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
                            @foreach($choiceInfo as $key => $choice)
                                @if($choice != "")
                                    <input class="uk-input" type="text" name="choices[]"
                                            value="{{$choice}}">
                                @elseif(count($choiceInfo) <= 2)
                                    <input class="uk-input" type="text" name="choices[]">
                                @endif
                            @endforeach
                        @endif

                        </div>
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="point">持ち点</label>
                    @if(old('point'))
                        <input class="uk-margin-bottom uk-input" type="text" name="point" id="point_view" value="{{old('point')}}">
                        <input class="uk-range" id="point" type="range" value="{{old('point')}}" min="1" max="10"
                                step="1">
                    @else
                        <input class="uk-margin-bottom uk-input" type="text" name="point" id="point_view" value="{{$oldQuestionInfo->point}}">
                        <input class="uk-range" id="point" type="range" value="{{$oldQuestionInfo->point}}" min="1" max="10"
                                step="1">
                    @endif
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label uk-text-bold" for="limit">締切日</label>
                    <div class="uk-form-controls">

                    @if(old('limit'))
                        <input class="uk-input" id="limit" type="date" name="limit"
                                value="{{old('limit')}}">
                    @else
                        <input class="uk-input" id="limit" type="date" name="limit"
                                value="{{$oldQuestionInfo->limit}}">
                    @endif

                    </div>
                </div>

                <div class="uk-margin">
                    <div class="uk-form-label uk-text-bold">オプション</div>
                    <div class="uk-form-controls">

                        @if(old('options'))
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="options[]" value="1"
                                      @if(in_array('1', old('options')))
                                      checked
                                      @endif>
                                      ゲストの回答を許可
                        </label><br>
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="options[]" value="2"
                                      @if(in_array('2', old('options')))
                                      checked
                                      @endif> 一般公開
                        </label><br>
                        <label>
                            <input class="uk-checkbox" type="checkbox" id="is_edit" name="options[]" value="3"
                                      @if(in_array('3', old('options')))
                                      checked
                                      @endif> 投稿後の編集可能
                        </label>
                        @else
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="options[]" value="1"
                                      @if($oldQuestionInfo->is_anyone)
                                      checked
                                      @endif>
                                      ゲストの回答を許可
                        </label><br>
                        <label>
                            <input class="uk-checkbox" type="checkbox" name="options[]" value="2"
                                      @if($oldQuestionInfo->is_open_view)
                                      @endif> 一般公開
                        </label><br>
                        <label>
                            <input class="uk-checkbox" type="checkbox" id="is_edit" name="options[]" value="3"
                                      @if($oldQuestionInfo->is_edit == 1) checked @endif> 投稿後の編集可能
                        </label>
                        @endif
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