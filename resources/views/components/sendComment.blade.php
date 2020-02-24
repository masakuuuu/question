<div class="uk-section uk-section-muted uk-padding-remove-top">
    <div class="uk-flex uk-flex-center">

        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle" uk-grid>

                    <div class="uk-width-auto">
                        @if (Session::has('profile_image_url_https'))
                            <img class="uk-border-circle" width="40" height="40"  src="{{ Session::get('profile_image_url_https') }}">
                        @endif
                    </div>
                    <div class="uk-width-expand">
                        <form action="SendComment" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="url_hash" value="{{$questionInfo->url_hash}}">
                            <input type="hidden" name="question_id" value="{{$questionInfo->id}}">
                            <div class="uk-margin">
                                <textarea class="uk-textarea" rows="3" name="comment"  placeholder="コメント"></textarea>
                            </div>
                            <button class="uk-button uk-button-primary uk-button-small" type="submit" >送信</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <ul id="newQuestion" class="uk-list uk-list-divider">
                    @if(count($commentList))
                        @foreach($commentList as $comment)
                            <li>
                                {{ $comment->comment }} by {{ $comment->user_name }}
                            </li>
                        @endforeach
                    @else
                        <li>
                            現在コメントはありません
                        </li>
                    @endif
                </ul>
            </div>
            <div class="uk-card-footer">
                <a href="#" class="uk-button uk-button-text">さらに読み込む</a>
            </div>
        </div>

    </div>
</div>


