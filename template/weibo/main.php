<h1 class="heading g12">编辑操作员信息</h1>

<div class="fullCol">
    <!-- Widget -->
    <div class="widget">
        <div class="title">
            <h4><span class="icon magic"></span>查看微博</h4>
            <a href="#" class="minimize">Minimize</a>
        </div>

        <div class="content">
            <form class="form wizzard" action="<?php echo $this->createUrl( 'user' , 'edit' ); ?>" method="post" id="signupForm">
                <ul>
                    <?php foreach( $friendsTimeline as $weibo ): ?>
                        <li>
                            <div class="label oneFourth">
                                <img src="<?php echo $weibo[ 'user' ][ 'profile_image_url' ] ?>"/>
                                <?php echo $weibo[ 'user' ][ 'screen_name' ] ?>
                            </div>
                            <div class="input threeFourth">
                                <?php echo $weibo[ 'text' ]; ?>
                                <?php if( ( $retweet = $weibo[ 'retweeted_status' ] ) ): ?>
                                    <br/>
                                    <?php echo $retweet[ 'text' ] ?>
                                <?php endif; ?>
                            </div>
                            <div class="clear"></div>
                        </li>
                    <?php endforeach; ?>
                </ul>	  
            </form>
            <a href="#" onclick="location.href='<?php echo $this->createUrl( 'weibo' , 'main' , array( 'page' => $page - 1 ) ); ?>'">上一页</a>
            <a href="#" onclick="location.href='<?php echo $this->createUrl( 'weibo' , 'main' , array( 'page' => $page + 1 ) ); ?>'">下一页</a>
        </div>

    </div>
    <!-- Widget ends -->
</div>
<div class="clear"></div>