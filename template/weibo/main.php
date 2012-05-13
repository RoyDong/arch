<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Hurricane - Liquid and Responsive admin template</title>
        <meta name="author" content="SuggeElson" />

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

        <link href='http://fonts.googleapis.com/css?family=Amethysta' rel='stylesheet' type='text/css' /> <!-- Custom google fonts -->
        <link href="css/admin.css" rel="stylesheet" type="text/css" />
        <link type="text/css" href="css/hurricane-theme/jquery.ui.hurricane.css" rel="stylesheet" />
        <!--[if IE]>
        <link type="text/css" href="css/ie.css" rel="stylesheet" />
        <![endif]-->

        <!-- Javascripts -->

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

        <script type="text/javascript" src="js/calendar/calendar.min.js"></script>
        <script type="text/javascript" src="js/jquery.rotate.2.1.js"></script>

        <script type="text/javascript" src="js/form/jquery.elastic.js"></script>
        <script type="text/javascript" src="js/form/elrte.min.js"></script>
        <script type="text/javascript" src="js/form/jquery.inputlimiter.1.2.3.min.js"></script>
        <script type="text/javascript" src="js/form/jquery.autoGrowInput.js"></script>
        <script type="text/javascript" src="js/form/jquery.tagedit.js"></script>
        <script type="text/javascript" src="js/form/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="js/form/jquery.dualListBox-1.3.min.js"></script>
        <script type="text/javascript" src="js/form/jquery.maskedinput-1.3.js"></script>
        <script type="text/javascript" src="js/form/formToWizard.js"></script>
        <script type="text/javascript" src="js/form/jquery.validate.min.js"></script>
        <script type="text/javascript" src="js/form/jquery.checkbox.js"></script>
        <script type="text/javascript" src="js/form/jquery.defaultvalue.js"></script>
        <script type="text/javascript" src="js/form/ui.spinner.js"></script>
        <script type="text/javascript" src="js/form/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="js/form/colorpicker.js"></script>
        <script type="text/javascript" src="js/form/jquery.ui.timepicker.js"></script>

        <script type="text/javascript" src="js/tables/jquery.dataTables.js"></script>
        <script type="text/javascript" src="js/tables/jquery.columnFilter.js"></script>
        <script type="text/javascript" src="js/tables/jquery.colResizeReorder.js"></script>

        <script type="text/javascript" src="js/plupload/plupload.js"></script>
        <script type="text/javascript" src="js/plupload/plupload.html4.js"></script>
        <script type="text/javascript" src="js/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
        <script type="text/javascript" src="js/elfinder/elfinder.min.js"></script>

        <script type="text/javascript" src="js/jquery.scrollTo-min.js"></script>
        <script type="text/javascript" src="js/jquery.jgrowl.js"></script>
        <script type="text/javascript" src="js/jquery.progressbar.js"></script>
        <script type="text/javascript" src="js/xbreadcrumbs.js"></script>

        <script type="text/javascript" src="js/gallery/jquery.adipoli.min.js"></script>
        <script type="text/javascript" src="js/gallery/jquery.prettyPhoto.js"></script>

        <script type="text/javascript" src="js/jquery.codeview.js"></script>
        <script type="text/javascript" src="js/jquery.tipsy.js"></script>

        <!--[if IE]>
        <script type="text/javascript" src="js/flot/excanvas.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="js/flot/jquery.flot.js"></script>
        <script type="text/javascript" src="js/flot/jquery.flot.pie.js"></script>
        <script type="text/javascript" src="js/flot/jquery.flot.resize.js"></script>
        <script type="text/javascript" src="js/flot/jquery.flot.orderBars.js"></script>

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.js"></script> <!-- Important place before admin.js -->

        <script type="text/javascript" src="js/admin.js"></script>
    </head>

    <body>

        <div id="container"><!-- Container -->

            <!-- Sidebar -->
            <div id="sidebar">

                <!-- Logo -->
                <div class="logo">
                    <a href="login.html">
                        <img src="images/dark/logo.png" alt="logo" /><br/><br/>
                        <span class="head">微薄管理平台</span>
                        <span class="subhead">version 0.1</span>
                    </a>
                </div>
                <!-- End logo -->


                <!-- navigation -->
                <div class="navigation">
                    <ul class="mainnav">
                        <li class="iMenu">
                            <a href="#"><span class="icon circleArrowDown"></span><span class="txt">Navigation</span></a>
                        </li>
                        <li class="iAvatar">
                            <a href="#"><img src="images/dark/icon/yellow16/icon_user.png"  transparentalt="avatar" /><span class="txt">欢迎回来，管理员 XXX</span></a>
                            <ul class="sub">
                                <li><a href="editmanger.html"><span class="icon edit small"></span>编辑管理员信息</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><span class="icon display"></span><span class="txt">Dashboard</span></a></li>
                        <li>
                            <a href=""><span class="icon moreWindows"></span>帐户属性设置</a>
                            <ul class="sub expand">
                                <li><a href="userlist.html" class="current"><span class="icon table small"></span>查看操作员列表</a></li>
                                <li><a href="adduser.html"><span class="icon userAdd small"></span>增加操作员</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><span class="icon computerService"></span>基本属性设置</a>
                            <ul class="sub expand">
                                <li><a href="industrylist.html"><span class="icon play small"></span>查看行业列表</a></li>
                                <li><a href="addindustry.html"><span class="icon play small"></span>添加新行业</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
                <!-- End navigation -->
                <div class="clearfix"></div>
            </div>
            <!-- End sidebar -->

            <!-- Content -->
            <div id="content">

                <!-- Toparea -->
                <div class="topArea">

                    <!-- notification bar -->
                    <div class="notificationBar">
                        <ul class="topNav">
                            <li>
                                <a href="#" title="Activity"><span class="icon history small"></span><span class="txt">操作员数</span><span class="notification">5</span></a>
                                <ul class="sub">
                                    <li><a href="#"><span class="icon repeat small"></span>小A</a></li>
                                    <li><a href="#"><span class="icon userRemove small"></span>小B</a></li>
                                    <li><a href="#"><span class="icon comments small"></span>小C</a></li>
                                    <li><a href="#"><span class="icon databasePlus small"></span>小D</a></li>
                                    <li><a href="#"><span class="icon birthdayCake small"></span>小E</a></li>
                                </ul>
                            </li>
                            <li><a href="weibolist.html" title="Orders"><span class="icon shoppingCart small"></span><span class="txt">帐户管理数</span><span class="notification">542</span></a>
                            </li>
                            <li><a href="#" title="Settings"><span class="icon cogwheel small"></span><span class="txt">设置</span></a></li>
                            <li><a href="index.html" title="Logout"><span class="icon power small"></span><span class="txt">登出</span></a></li>
                        </ul>
                    </div>
                    <!-- End notification bar -->
                </div>
                <!-- End toparea -->

                <!-- mainContent start  -->	
                <div id="mainContent">

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
                                        <?php foreach( $friendsTimeline as $weibo ):?>
                                        <li>
                                            <div class="label oneFourth">
                                                <img src="<?php echo $weibo['user']['profile_image_url']?>"/>
                                                <?php echo $weibo['user']['screen_name']?>
                                            </div>
                                            <div class="input threeFourth">
                                                <?php echo $weibo['text'];?>
                                                <?php if( ( $retweet = $weibo['retweeted_status'] ) ):?>
                                                <br/>
                                                    <?php echo $retweet['text']?>
                                                <?php endif;?>
                                            </div>
                                            <div class="clear"></div>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>	  
                                </form>
                                <a href="#" onclick="location.href='<?php echo $this->createUrl( 'weibo' , 'main' , array( 'page' => $page-1 ) );?>'">上一页</a>
                                <a href="#" onclick="location.href='<?php echo $this->createUrl( 'weibo' , 'main' , array( 'page' => $page+1 ) );?>'">下一页</a>
                            </div>

                        </div>
                        <!-- Widget ends -->
                    </div>
                    <div class="clear"></div>

                </div>
                <!-- End of mainContent -->	

            </div>
            <!-- End Content -->
            <div id="footer">
                <p>&copy; 2012 UCD-China Inc. All rights reserved!</p>
            </div>
        </div> <!-- End Container -->
    </body>
</html>