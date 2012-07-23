<textarea id="text"></textarea>
<button onclick="ajax()">write</button>
<script>
function ajax(){
    $.ajax({
        headers: {'Data-Type': 'text'},
        url: '/write',
        type: 'post',
        data: {
            m: 'add',
            text: $('#text').val()
        },
        success: function(data){
            console.log(data);
        },
        error: function(data){
            console.log(data.responseText);
        }
    });
}
</script>