<pre><?php print_r($_COOKIE)?></pre>
<textarea id="text"></textarea>
<button onclick="ajax()">write</button>
<script>
    function ajax(){
        document.domain = 'diary.tool';
        $.ajax({
            headers: {'Data-Type': 'text'},
            url: 'http://dev.diary.tool/test',
            type: 'post',
            data: {
                ARCH_CSRF: '<?php echo \Arch::$command->csrf ?>',
                m: 'add',
                text: $('#text').val()
            },
            success: function(data){
                console.log(data);
            },
            error: function(data){
                console.log(data);
                console.log(data.responseText);
            }
        });
    }
    /*
                $.ajax({
                    type:"GET",
                    url:"http://bdc.dict.cn/",
                    data:{
                        lastbook: getCookie('lastbook'),
                        action:"save",
                        page:_dict_bdc.page
                    },
                    error:function(a){
                        console.log(a);
                    },
                    success:function(a){
                        console.log(a);
                    },
                    cache:false
                });
                autoSave.running=[]
                */
</script>
<form action="/test" method="post">
    <input type="hidden" name="m" value="add"/>
    <input type="text" name="text" />
    <input type="submit" value="submit"/>
</form>