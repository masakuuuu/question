<div class="uk-section uk-section-muted">
    <div uk-slider="center: true">

        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

            <ul class="uk-slider-items uk-child-width-1-2@s uk-grid">

                @if(count($hot_questions))
                    @foreach($hot_questions as $question)



                        <li>
                            @if(session('twitter_user_id'))

                                <a href="Answer?url_hash={{ $question->url_hash }}">
                                    <div class="uk-card uk-card-default" style="padding: 20px">
                                        <article class="uk-comment">
                                            <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
                                                <div class="uk-width-auto">
                                                    <img class="uk-comment-avatar uk-border-circle" src="{{ $question->thumbnail }}" width="60" height="60" alt="">
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class=" uk-margin-remove uk-comment-body"><span class="uk-link-reset uk-text-secondary" style="color: #1b1e21">{{ $question->question_title }}</span></h4>
                                                    <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                                                        <li><span style="color: #4e555b ; text-transform: none">{{ $question->auther_name }}</span></li>
                                                    </ul>
                                                </div>
                                            </header>
                                            <div class="uk-comment-body uk-text-center uk-text-bold" style="padding: 10px">
                                                <p>{{ $question->question_detail }}</p>
                                            </div>
                                        </article>
                                    </div>
                                </a>

                            @else

                                <a href="ViewVoteAnswer?url_hash={{ $question->url_hash }}">
                                    <div class="uk-card uk-card-default" style="padding: 20px">
                                        <article class="uk-comment">
                                            <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
                                                <div class="uk-width-auto">
                                                    <img class="uk-comment-avatar uk-border-circle" src="{{ $question->thumbnail }}" width="60" height="60" alt="">
                                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class=" uk-margin-remove uk-comment-body"><span class="uk-link-reset uk-text-secondary" style="color: #1b1e21">{{ $question->question_title }}</span></h4>
                                                    <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                                                        <li><span style="color: #4e555b; text-transform:none">{{ $question->auther_name }}</span></li>
                                                    </ul>
                                                </div>
                                            </header>
                                            <div class="uk-comment-body uk-text-center uk-text-bold" style="padding: 10px">
                                                <p>{{ $question->question_detail }}</p>
                                            </div>
                                        </article>
                                    </div>
                                </a>

                            @endif

                        </li>

                    @endforeach
                @else
                    <li>
                        集計が終了しているアンケートがありません
                    </li>
                @endif
            </ul>

            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
               uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
               uk-slider-item="next"></a>

        </div>

        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

    </div>
</div>