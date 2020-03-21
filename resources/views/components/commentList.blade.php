{{--
<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-margin">
                <ul id="newQuestion" class="uk-list uk-list-divider">
                    @if(count($commentList))
                        @foreach($commentList as $comment)

                        <div class="uk-grid-small uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <img class="uk-border-circle" width="40" height="40" src="{{ $questionInfo->thumbnail }}">
                            </div>
                            <div class="uk-width-expand">
                                <h3 class="uk-card-title uk-margin-remove-bottom">{{ $comment->user_name }}</h3>
                                <p class="uk-text-meta uk-margin-remove-top">
                                {{ $comment->comment }}
                                </p>
                            </div>
                        </div>

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
