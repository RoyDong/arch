<h1 class="heading g12">增加新用户</h1>

<div class="fullCol">
    <!-- Widget -->
    <div class="widget">
        <div class="title">
            <h4><span class="icon magic"></span>增加新用户</h4>
            <a href="#" class="minimize">Minimize</a>
        </div>
        <div class="content">
            <form class="form wizzard" action="<?php echo $this->createUrl( 'user' , 'new' ); ?>" method="post" id="signupForm">
                <ul>
                    <li>
                        <div class="label oneFourth"><label for="text">用户名</label></div>
                        <div class="input threeFourth"><input type="text" id="username" name="username" /></div>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <div class="label oneFourth"><label for="text">电子邮箱</label></div>
                        <div class="input threeFourth"><input type="text" id="email" name="email" /></div>
                        <div class="clear"></div>
                    </li>
                    </fieldset>
                    <li class="lastest">
                        <input type="submit" class="button gray"  value="添 加"/><?php echo $this->cookie( 'flash' ); ?>
                    </li>
                    </fieldset>
                </ul>
            </form>
        </div>

    </div>
    <!-- Widget ends -->
</div>
<div class="clear"></div>