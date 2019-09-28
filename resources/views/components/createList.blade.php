<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-margin">
                <ul id="newQuestion" class="uk-list uk-list-divider">
                    @if(count($questionsList))
                        @foreach($questionsList as $question)
                            <li>
                                {{ $question->question_title }}
                            </li>
                        @endforeach
                    @else
                        <li>
                            現在質問は作成していません
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>