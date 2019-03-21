<script>
    $(function(){
        $('#choices').on('click', function(){
            $('#choices').trigger('create').append('<div class="uk-form-controls">\n' +
                '                     <input class="uk-input" type="text" name="question_title"\n' +
                '                            placeholder="Some text...">\n' +
                '                  </div>');
        })
    });
</script>

<div class="uk-section uk-section-muted">
    <div class="uk-flex uk-flex-center">

    </div>
</div>