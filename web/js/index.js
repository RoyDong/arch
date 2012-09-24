$(function(){
    var selectedTitle;
    $('#article-bar li').bind({
        mouseenter: function(){
            if($(this).hasClass('bar-title-select')) return;
            $(this).addClass('bar-title-hover');
        },
        mouseleave: function(){
            if($(this).hasClass('bar-title-select')) return;
            $(this).removeClass('bar-title-hover');
        },
        click: function(){
            if($(this).hasClass('bar-title-select')){
                
                return;
            }

            if( selectedTitle ){
                selectedTitle.removeClass('bar-title-select');
                selectedTitle.attr('title', '');
            }

            selectedTitle = $(this);
            selectedTitle.removeClass('bar-title-hover');
            selectedTitle.addClass('bar-title-select');
            selectedTitle.attr('title', '点击回到顶部');
        }
    });

    var Title = {
        select: null,

        offset: 0,

        count: TITLES.length,

        refresh: function(){

        }
    };
});