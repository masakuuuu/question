<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            @if($isAnswered)
                <div class="uk-card-body">
                    <p>解答済みのアンケートです</p>
                </div>
            @endif
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                        <img class="uk-border-circle" width="40" height="40" src="{{ $questionInfo->thumbnail }}">
                    </div>
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title uk-margin-remove-bottom">{{ $questionInfo->question_title }}</h3>
                        <p class="uk-text-meta uk-margin-remove-top">
                            {{ $questionInfo->auther_name }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <p>{{ $questionInfo->question_detail }}</p>
            </div>
            <div class="uk-card-footer">
                <table class="uk-table uk-table-hover uk-table-divider">
                    <thead>
                    <tr>
                        <th class="uk-text-center">選択肢</th>
                        <th class="uk-text-center">投票数</th>
                        <th class="uk-text-center">ユーザ数</th>
                        <th class="uk-text-center">分布</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($answerInfo as $answer)
                        <tr>
                            <td>
                                {{$answer->choice_text}}
                            </td>
                            <td class="uk-text-right">
                                {{$answer->votes}}
                            </td>
                            <td class="uk-text-right">
                                {{$answer->user_count}}
                            </td>
                            <td class="uk-text-center">
                                @if($answer->user_count > 0)
                                    <span uk-icon="search" data-toggle="modal" data-target="#exampleModalCenter" onclick="getUserList( {{ $answer->choice_id }} )"></span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text={{ $questionInfo->question_title }}&hashtags=quepon" data-size="large">Tweet</a>
                <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

                <p class="uk-text-muted">締切日： {{ $questionInfo->limit }} </p>
            </div>
        </div>
    </div>
</div>