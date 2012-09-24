<?php $h->javascript(['/kindeditor/kindeditor.js', '/kindeditor/lang/zh_CN.js'])?>
<?php $h->stylesheet('/css/write.css')?>
<center>
    <h2>Write your article</h2>
</center>
<div style="margin: 10px auto;width: 960px;">
    <div style="margin-bottom: 20px">
        <label>Title: </label><input type="text" id="title"/>
    </div>
    <textarea id="editor"></textarea>
    <button style="margin-top: 10px" id="save">Save (Ctrl+Enter)</button>
</div>
<script type="text/javascript" >
    var ARCH_CSRF = '<?php echo \Arch::$command->csrf?>';
    var EDITOR;
    KindEditor.ready(function(K){
        EDITOR = K.create('#editor', {
            width: '960px',
            height: '650px'
        });
    });
    $('#save').click(function(){
        var title = $('#title').val();
        var content = EDITOR.html();

        if( content && title ){
            $.ajax({
                url: '/write.txt',
                type: 'post',
                data: {
                    m: 'add',
                    ARCH_CSRF: ARCH_CSRF,
                    title: $('#title').val(),
                    content: EDITOR.html()
                },
                success: function(id){
                    if(id > 0){
                        $('#title').val('');
                        EDITOR.html('');
                    }
                },
                error: function(data){
                    alert(data.responseText);
                }
            });
        }else
            alert('title and content cant be empty');
    });
</script>