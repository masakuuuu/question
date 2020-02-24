{{--
<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-margin">
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
        </div>
    </div>
</div>--}}
