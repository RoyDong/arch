<?php $h->javascript(['/kindeditor/kindeditor.js', '/kindeditor/lang/zh_CN.js'])?>
<?php $h->stylesheet('/css/write.css')?>
<center>
    <h2>Write your article</h2>
</center>
<div style="margin: 10px auto;width: 960px;">
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
        $.ajax({
            url: '/write',
            type: 'post',
            data: {
                m: 'add',
                ARCH_CSRF: ARCH_CSRF,
                text: EDITOR.html()
            },
            success: function(data){
                console.log(data)
            },
            error: function(data){
                console.log(data.responseText)
            }
        });
    });
</script>