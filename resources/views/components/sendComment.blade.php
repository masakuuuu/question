<div class="uk-section uk-section-muted uk-padding-remove-top">
    <div class="uk-flex uk-flex-center">

        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle" uk-grid>

                    <div class="uk-width-auto">
                        @if (Session::has('profile_image_url_https'))
                            <img class="uk-border-circle" width="40" height="40"  src="{{ Session::get('profile_image_url_https') }}">
                        @else
                            <img class="uk-border-circle" width="40" height="40"  src="/img/gest_icon.png">
                        @endif
                    </div>
                    <div class="uk-width-expand">
                        <form action="SendComment" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="url_hash" value="{{$questionInfo->url_hash}}">
                            <input type="hidden" name="question_id" value="{{$questionInfo->id}}">
                            @if (!Session::has('profile_image_url_https'))
                                <input class="uk-input" id="commentName" type="text" name="comment_name" value="{{old('comment_name')}}" placeholder="名無しさん">
                            @endif
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
                            @if($comment->name)
                            <a class="uk-link-heading" target="_brank" href="https://twitter.com/{{ $comment->name }}">
                            @endif
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-auto">
                                    @if($comment->thumbnail)
                                        <img class="uk-border-circle" width="40" height="40" src="{{ $comment->thumbnail }}">
                                    @else
                                        <img class="uk-border-circle" width="40" height="40" src="/img/gest_icon.png">
                                    @endif
                                    </div>
                                    <div class="uk-width-expand">
                                        <p class="uk-text-bold uk-margin-remove-bottom"><span>{{ $comment->user_name }}</span><span class="uk-text-muted uk-margin-small-left">aaaa</span></p>
                                        <p class="uk-margin-remove-top">
                                        {{ $comment->comment }}
                                        </p>
                                    </div>
                                </div>
                            @if($comment->name)
                            </a>
                            @endif
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


