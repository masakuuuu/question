<div class="uk-section uk-section-muted">
    <div uk-slider="center: true">

        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">

            <ul class="uk-slider-items uk-child-width-1-2@s uk-grid">

                @if(count($hot_questions))
                    @foreach($hot_questions as $question)
                        <li>
                            @if(session('twitter_user_id'))
                                <a href="Answer?url_hash={{ $question->url_hash }}">
                                    <div class="uk-card uk-card-default">
                                        <div class="uk-card-media-top">
                                            <img src="images/photo.jpg" alt="">
                                        </div>
                                        <div class="uk-card-body">
                                            <h3 class="uk-card-title">{{ $question->question_title }}</h3>
                                            <p>{{ $question->question_detail }}</p>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <a href="ViewVoteAnswer?url_hash={{ $question->url_hash }}">
                                    <div class="uk-card uk-card-default">
                                        <div class="uk-card-media-top">
                                            <img src="images/photo.jpg" alt="">
                                        </div>
                                        <div class="uk-card-body">
                                            <h3 class="uk-card-title">{{ $question->question_title }}</h3>
                                            <p>{{ $question->question_detail }}</p>
                                        </div>
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