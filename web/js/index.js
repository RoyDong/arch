$(function(){
    var selectedTitle;
    $('#article-bar li').live({
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
        data: TITLES,
        select: null,
        offset: 0,

        init: function(){
            var li , article;
            var ul = $('<ul>');
            for( var i = 0 , l = this.data.length ; i < l ; i++ ){
                article = this.data[i];
                li = '<li title="'+article.title+'"><span class="bar-title">'+
                    article.title+'</span><span class="bar-time">'+
                    article.ctime+'</span></li>';

                ul.append(li);
            }

            $('#article-bar #bar-list').append(ul);
        }
    };

    Title.init();
});