<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-margin">

                @if(count($questionsList))
                <table class="uk-table uk-table-hover uk-table-divider">
                    <thead>
                    <tr>
                        <th class="uk-text-center">タイトル</th>
                        <th class="uk-text-center">回答期限</th>
                        <th class="uk-text-center">ゲストの回答</th>
                        <th class="uk-text-center">公開レベル</th>
                        <th class="uk-text-center"></th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach($questionsList as $question)
                        <tr>
                            <td>
                                <a href="ViewAnswer?url_hash={{ $question->url_hash }}">{{ $question->question_title }}</a>
                            </td>
                            <td class="uk-text-right">
                                {{ $question->limit }}
                            </td>
                            <td class="uk-text-center">
                                @if($question->is_anyone)
                                <span class="uk-label">許可</span>
                                @else
                                <span class="uk-label uk-label-warning">禁止</span>
                                @endif
                            </td>
                            <td class="uk-text-center">
                                @if($question->is_open_view)
                                <span class="uk-label">一般</span>
                                @else
                                <span class="uk-label uk-label-warning">限定</span>
                                @endif
                            </td>
                            <td class="uk-text-center">
                                @if($question->is_edit)
                                @endif
                            </td>
                        </tr>
                    　　@endforeach

                    </tbody>
                </table>

                <div class="uk-text-center">
                {{ $questionsList->links('pagination::default') }}
                </div>

                @else
                <div>
                    まだ質問を投稿していません
                </div>
                @endif
            </div>
        </div>
    </div>
</div>