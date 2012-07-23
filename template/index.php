<button onclick="ajax('add')">add</button>
<button onclick="ajax('set')">set</button>
<script>
function ajax(m){
    $.ajax({
        headers: {'Data-Type': 'text'},
        url: '/',
        type: 'post',
        data: {m: m},
        success: function(data){
            console.log(data);
        },
        error: function(data){
            console.log(data.responseText);
        }
    });
}
</script>