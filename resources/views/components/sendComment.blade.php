<script>
    function getNextComment(){
        // 設定値の宣言
        let minGetFlg = true;
        let minId = null;

        $('.commentIds').each(function(index, value){
            // 最初のみ1つ目のIDを取得
            if(minGetFlg){
                minId = this.value;
                minGetFlg = false;
            }
            // 一番小さいIDを取得します
            if(minId > this.value){
                minId =  this.value;
            }
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
            }
        });

        $.ajax({
            url: 'GetNextComment',
            type: 'POST',
            data: {
                'url_hash' : '{{$questionInfo->url_hash}}',
                'commentId': minId
            }
        })

            .done(function(data) {
                if(data['nextCommentList'].length < 5){
                    $('#getNextComment').html('<p class="uk-text-muted">コメントをすべて読み込みました</p>')                    
                }

                for(var index in data['nextCommentList']){
                    if(data["nextCommentList"][index].name){
                    $('#commentList').trigger('create').append('<li>\n' +
                            '<a class="uk-link-heading" target="_brank" href="https://twitter.com/' + data["nextCommentList"][index].name + '">' + 
                            '<div class="uk-grid-small uk-flex-middle" uk-grid>' + 
                            '<div class="uk-width-auto">' + 
                            '<img class="uk-border-circle" width="40" height="40" src="'  + data["nextCommentList"][index].thumbnail +  '">' + 
                            '</div>' +
                            '<div class="uk-width-expand">' +
                            '<input type="hidden" class="commentIds" value="'+ data["nextCommentList"][index].id + '">' + 
                            '<p class="uk-text-bold uk-margin-remove-bottom"><span>'+ data["nextCommentList"][index].user_name + '</span><span class="uk-text-muted uk-margin-small-left">' + data["nextCommentList"][index].created_at + '</span></p>' +
                            '<p class="uk-margin-remove-top">' + data["nextCommentList"][index].comment + '</p>' +
                            '</div>' +
                            '</div>' +
                            '</a>');
                    } else {
                        $('#commentList').trigger('create').append('<li>\n' +
                            '<div class="uk-grid-small uk-flex-middle" uk-grid>' + 
                            '<div class="uk-width-auto">' + 
                            '<img class="uk-border-circle" width="40" height="40" src="/img/gest_icon.png">' + 
                            '</div>' +
                            '<div class="uk-width-expand">' +
                            '<input type="hidden" class="commentIds" value="'+ data["nextCommentList"][index].id + '">' + 
                            '<p class="uk-text-bold uk-margin-remove-bottom"><span>'+ data["nextCommentList"][index].user_name + '</span><span class="uk-text-muted uk-margin-small-left">' + data["nextCommentList"][index].created_at + '</span></p>' +
                            '<p class="uk-margin-remove-top">' + data["nextCommentList"][index].comment + '</p>' +
                            '</div>' +
                            '</div>');
                    }
                }
            })

            .fail(function() {
                alert('エラー');
            });

        }

    </script>

<div class="uk-section uk-section-muted uk-padding-remove-top">
    <div class="uk-flex uk-flex-center">

        <div class="uk-card uk-card-default uk-width-1-2@m">
            <div class="uk-card-header">
                <div class="uk-grid-small uk-flex-middle" uk-grid>

                    <div class="uk-width-auto">
                        @if (Session::has('profile_image_url_https'))
                            <img class="uk-border-circle" width="40" height="40"  src="{{ Session::get('profile_image_url_https') }}">
                        @else
                            <img class="uk-border-circle" width="40" height="40"  src="/img/gest_icon.png">
                        @endif
                    </div>
                    <div class="uk-width-expand">
                        @foreach($errors->all() as $error)
                            <div class="uk-text-warning">{{ $error }}</div>
                        @endforeach
                        <form action="SendComment" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="url_hash" value="{{$questionInfo->url_hash}}">
                            <input type="hidden" name="question_id" value="{{$questionInfo->id}}">
                            @if (!Session::has('profile_image_url_https'))
                                <input class="uk-input" id="commentName" type="text" name="comment_name" value="{{old('comment_name')}}" placeholder="投稿者名">
                            @endif
                            <div class="uk-margin">
                                <textarea class="uk-textarea" rows="3" name="comment"  placeholder="コメント">{{old('comment')}}</textarea>
                            </div>
                            <button class="uk-button uk-button-primary uk-button-small" type="submit" >送信</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="uk-card-body">
                <ul id="commentList" class="uk-list uk-list-divider">
                    @if(count($commentList))
                        @foreach($commentList as $comment)
                        <li>
                            @if($comment->name)
                            <a class="uk-link-heading" target="_brank" href="https://twitter.com/{{ $comment->name }}">
                            @endif
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-auto">
                                    @if($comment->thumbnail)
                                        <img class="uk-border-circle" width="40" height="40" src="{{ $comment->thumbnail }}">
                                    @else
                                        <img class="uk-border-circle" width="40" height="40" src="/img/gest_icon.png">
                                    @endif
                                    </div>
                                    <div class="uk-width-expand">
                                        <input type="hidden" class="commentIds" value="{{ $comment->id }}">
                                        <p class="uk-text-bold uk-margin-remove-bottom"><span>{{ $comment->user_name }}</span><span class="uk-text-muted uk-margin-small-left">{{ $comment->created_at }}</span></p>
                                        <p class="uk-margin-remove-top">
                                        {{ $comment->comment }}
                                        </p>
                                    </div>
                                </div>
                            @if($comment->name)
                            </a>
                            @endif
                        </li>
                        @endforeach
                    @else
                        <li>
                            現在コメントはありません
                        </li>
                    @endif
                </ul>
            </div>
            <div id="getNextComment" class="uk-card-footer">
                <a href="#" class="uk-button uk-button-text" onClick="getNextComment();return false">さらに読み込む</a>
            </div>
        </div>

    </div>
</div>
