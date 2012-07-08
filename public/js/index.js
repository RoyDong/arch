$(function(){
    var forms = $('#forms');

    $('#signin-form-btn').click(function(e){
        forms.animate({ 'margin-top': '-390px' } , 500 , function(){
            $( '#signin-email' ).focus();
        });
    });

    $('#signup-form-btn').click(function(e){
        forms.animate({ 'margin-top': '0px' } , 500 , function(){
            $( '#signup-email' ).focus();
        });
    });
});