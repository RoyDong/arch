<?php $this->stylesheet('/css/index.css'); ?>
<?php $this->javascript('/js/index.js'); ?>
<?php $this->title = '日记本'; ?>
<div id="main">
    <div id="left">
        <div id="left-content">
            <div id="forms-wrap">
                <div id="forms">
                    <div>填写下面的表单进行注册</div>
                    <form action="/signup" method="post">
                        <input type="hidden" name="m" value="add"/>
                        <ul>
                            <li>
                                <input type="text" placeholder="邮箱" name="email" id="signup-email" />
                            </li>
                            <li>
                                <input type="password" name="password" placeholder="密码" />
                            </li>
                            <li>
                                <input type="password" name="confirm" placeholder="确认密码" />
                            </li>
                            <li>
                                <input type="submit" value="注      册"/>
                            </li>
                        </ul>
                        <a href="javascript:;" id="signin-form-btn">取&nbsp;&nbsp;&nbsp;&nbsp;消</a>
                    </form>
                    <div>填写下面的表单进行登录</div>
                    <form action="/signin" method="post">
                        <input type="hidden" name="m" value="set"/>
                        <ul>
                            <li>
                                <input type="text" placeholder="邮箱" name="email" id="signin-email" />
                            </li>
                            <li>
                                <input type="password" name="password" placeholder="密码" />
                            </li>
                            <li>
                                <input type="submit" value="登      录"/>
                            </li>
                        </ul>
                        <a href="javascript:;" id="signup-form-btn">我要注册</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="right">
        <div id="right-title">
            <span>日记本</span>寻找生活的足迹
        </div>
        <div id="right-content">
            <ul>
                <li>随时随地记录你的生活，</li>
                <li>随时随地回顾你的历程。</li>
                <li>没有杂乱的评论，</li>
                <li>没有纷飞的转发。</li>
            </ul>
        </div>
        <div id="copy-right">
            diary.com &copy; | 联系我们: <a href="mailto:roy.dongwei@gmail.com">roy.dongwei@gmail.com</a> 
        </div>
    </div>
    <div class="clear"></div>
</div>