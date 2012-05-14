<h1 class="heading g12">编辑操作员信息</h1>
<div class="fullCol">
    <!-- Widget -->
    <div class="widget">
        <div class="title">
            <h4><span class="icon magic"></span>编辑操作员信息</h4>
            <a href="#" class="minimize">Minimize</a>
        </div>

        <div class="content">
            <form class="form wizzard" action="<?php echo $this->createUrl( 'user' , 'edit' ); ?>" method="post" id="signupForm">
                <ul>
                    <li class="lastest">
                        <div class="label oneFourth"><label for="text">邮箱</label></div>
                        <div class="input threeFourth"><?php echo $user->email; ?></div>
                        <div class="clear"></div>
                    </li>
                    <li class="lastest">
                        <div class="label oneFourth"><label for="text">名字</label></div>
                        <div class="input threeFourth"><input type="text" id="username" name="username" value="<?php echo $user->username; ?>"/></div>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <div class="label oneFourth"><label for="text">密码</label></div>
                        <div class="input threeFourth"><input type="text" id="password" name="password" value="<?php echo $user->password ?>"/></div>
                        <div class="clear"></div>
                    </li>
                    <li class="lastest">
                        <div class="label oneFourth"><label for="text">公司</label></div>
                        <div class="input threeFourth"><input type="text" id="name" name="name" /></div>
                        <div class="clear"></div>
                    </li>
                    <li class="lastest">
                        <div class="label oneFourth"><label for="text">部门</label></div>
                        <div class="input threeFourth"><input type="text" id="name" name="name" /></div>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <div class="label oneFourth"><label for="text">手机</label></div>
                        <div class="input threeFourth"><input type="text" id="name" name="name" /></div>
                        <div class="clear"></div>
                    </li>
                    </fieldset>
                    <li class="lastest">
                        <input type="submit" class="button gray" value="确认提交" />
                    </li>
                    </fieldset>
                </ul>	  
            </form>
        </div>

    </div>
    <!-- Widget ends -->
</div>
<div class="clear"></div>