<?php $h->javascript(['/kindeditor/kindeditor.js', '/kindeditor/lang/zh_CN.js'])?>
<script type="text/javascript" >
    var editor;
    KindEditor.ready(function(K){
        editor = K.create('#editor', {
            width: '900px',
            height: '400px'
        });
    });
</script>
<textarea style="margin: 0px auto;width: 960px" id="editor"></textarea>