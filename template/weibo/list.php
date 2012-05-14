<h1 class="heading">查看操作员 test 绑定的微薄列表</h1>
<input type="text" name="searchtxt" class="topSearch" placeholder="搜索微博 ..." / style="width:20%; height:20px;"> <button class="button gray">搜索</button><br />
<br />

<div class="fullCol">

    <!-- Widget -->
    <div class="widget">
        <div class="title">
            <h4><span class="icon picture"></span>微薄列表</h4>
            <a href="#" class="minimize">Minimize</a>
        </div>

        <div class="content">
            <table cellpadding="0" cellspacing="0" border="0" class="dynamicTable display">
                <thead>
                    <tr>
                        <th width="11%">微博头像</th>
                        <th width="11%">微博账户名</th>
                        <th width="6%">是否加V</th>
                        <th width="15%">所属行业</th>
                        <th width="8%">服务级别</th>
                        <th colspan="2">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $weiboList as $tokenId => $weibo ): ?>
                        <tr class="gradeX">
                            <td align="center" valign="middle"><img src="<?php echo $weibo[ 'sns_avatar' ]; ?>" alt="gallery" width="50" /></td>
                            <td align="center" valign="middle"><?php echo $weibo[ 'sns_name' ]; ?></td>
                            <td align="center" valign="middle"><?php echo $weibo[ 'verified' ] ? '是' : '否'; ?></td>
                            <td align="center" valign="middle">未知</td>
                            <td align="center" valign="middle">Level 0</td>
                            <td colspan="2" align="center" valign="middle" class="center" width="7%">
                                <a onclick="location.href='<?php echo $this->createUrl( 'weibo' , 'delete' , array( 'tokenId' => $tokenId ) ); ?>'" href="#">解除绑定</a>
                                <?php if( $this->user->oauth_token_id != $tokenId ): ?>
                                    <a onclick="location.href='<?php echo $this->createUrl( 'weibo' , 'default' , array( 'tokenId' => $tokenId ) ); ?>'" href="#">设为默认</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr align="left">
                        <th colspan="8"><a href="editweibo.html"><button class="button gray">编辑帐户信息</button></a>
                            <a href="#"><button class="button gray">绑定</button></a>
                            <a href="settags.html"><button class="button gray">标签设置</button></a>
                            <a href="setindustry.html"><button class="button gray">行业设置</button></a>
                            <a href="setlevel.html"><button class="button gray">服务级别设置</button></a></th>
                    </tr>
                </tfoot>
            </table>

            <div class="clear"></div>  
            <div style="display: none;" class="green-black"><span class="disabled"> <  上一页</span><span class="current">1</span><a href="#?page=2">2</a><a href="#?page=3">3</a><a href="#?page=4">4</a><a href="#?page=5">5</a><a href="#?page=6">6</a><a href="#?page=7">7</a>...<a href="#?page=199">199</a><a href="#?page=200">200</a><a href="#?page=2">下一页  > </a>
            </div>
        </div>

    </div>
    <!-- Widget ends -->
</div>

<div class="clear"></div>        