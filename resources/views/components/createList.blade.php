<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">
        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-margin">

                <table class="uk-table uk-table-hover uk-table-divider">
                    <thead>
                    <tr>
                        <th class="uk-text-center">タイトル</th>
                        <th class="uk-text-center">回答期限</th>
                    </tr>
                    </thead>
                    <tbody>

                    @if(count($questionsList))
                        @foreach($questionsList as $question)
                        <tr>
                            <td>
                                <a href="ViewAnswer?url_hash={{ $question->url_hash }}">{{ $question->question_title }}</a>
                            </td>
                            <td class="uk-text-right">
                                {{ $question->limit }}
                            </td>
                        </tr>
                    　　@endforeach
                    @else
                        <tr>
                            <td>
                            </td>
                            <td class="uk-text-right">
                            </td>
                            <td class="uk-text-right">
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>