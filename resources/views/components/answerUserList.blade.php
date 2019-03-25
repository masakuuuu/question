<meta name="token" content="{{ csrf_token() }}">
<script>
    $(function() {
        $('#deleteTarget').on('click', function() {

        });
    });
    function getUserList(choiceId){
        // 表示データの準備
        //// ユーザデータのリセット
        $('#answeredUserDataList').empty();
        $('#answeredUserDataTable').hide();

        //// ローディングの表示
        $('.modal-body').trigger('create').append('<div class="d-flex justify-content-center" id="loading">\n' +
        '<div class="spinner-border text-primary" role="status">\n' +
        '<span class="sr-only">Loading...</span>\n' +
        '</div>\n' +
        '</div>');

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

            .done(function(data) {

                $('#answeredUserDataTable').show();

                //// ローディングの表示
                $('#loading').remove();

                for(var index in data['AnsweredUserData']){
                    $('#answeredUserDataList').trigger('create').append('<tr>\n' +
                        '                     <td>' + data["AnsweredUserData"][index].user_name + '</td>"\n' +
                        '                     <td>' + data["AnsweredUserData"][index].votes + '</td>"\n' +
                        '                     <td>' + data["AnsweredUserData"][index].updated_at + '</td>"\n' +
                        '                  </tr>');
                }
            })

            .fail(function() {
                alert('エラー');
            });
    }
</script>

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

                <table class="uk-table uk-table-small uk-table-divider" id="answeredUserDataTable">
                    <thead>
                    <tr>
                        <th>ユーザ名</th>
                        <th>投票数</th>
                        <th>投票日時</th>
                    </tr>
                    </thead>
                    <tbody id="answeredUserDataList">
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>