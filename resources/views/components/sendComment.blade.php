<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-margin">
                <form action="SendComment" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="url_hash" value="{{$questionInfo->url_hash}}">
                    <input type="hidden" name="question_id" value="">
                    <textarea name="comment" placeholder="コメント"></textarea>
                    <input type="submit" value="送信">
                </form>
            </div>
        </div>
    </div>
</div>