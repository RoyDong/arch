<textarea id="text"></textarea>
<button onclick="ajax()">write</button>
<script>
function ajax(){
    $.ajax({
        headers: {'Data-Type': 'text'},
        url: '/test',
        type: 'post',
        data: {
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
</script>
<form action="/test" method="post">
    <input type="hidden" name="m" value="add"/>
    <input type="text" name="text" />
    <input type="submit" value="submit"/>
</form>