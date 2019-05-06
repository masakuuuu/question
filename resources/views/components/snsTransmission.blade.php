<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-margin">
                <textarea class="uk-textarea" rows="5" placeholder="Textarea"  readonly onclick="this.select();">{{ $questionInfo->question_title }}
{{ action('AnswerController@answer', 'url_hash=' . $questionInfo->url_hash) }}
                </textarea>
            </div>
        </div>
    </div>
</div>