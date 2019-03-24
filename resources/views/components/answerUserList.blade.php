<meta name="token" content="{{ csrf_token() }}">
<script>
    $(function() {
        $('#deleteTarget').on('click', function() {

        });
    });
    function getUserList(choiceId){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
            }
        });

        $.ajax({
            url: 'ViewAnsweredUserList',
            type: 'POST',
            data: {'choice_id': choiceId}
        })

            .done(function(answeredUserData) {
                // obj = JSON.parse(data);
                console.log(answeredUserData);
                for (var key in answeredUserData) {
                    console.log(answeredUserData[key]);
                    for(var data in answeredUserData[key]){
                        console.log(data);
                        console.log(data['user_name']);
                    }
                }
            })

            .fail(function() {
                alert('エラー');
            });
    }
</script>

<!-- icon trigger modal -->
<span uk-icon="search" data-toggle="modal" data-target="#exampleModalCenter" onclick="getUserList( {{ $answer->choice_id }} )"></span>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">ユーザの分布</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>名前</label>
                <input type="text" v-model="params.name">
                <br>
                <label>メールアドレス</label>
                <input type="text" v-model="params.email">
                <br>
                <label>内容</label>
                <textarea v-model="params.body"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>