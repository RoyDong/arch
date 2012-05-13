<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>微薄管理平台</title>
<meta name="author" content="UCD-China Inc." />

<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

<link href='http://fonts.googleapis.com/css?family=Amethysta' rel='stylesheet' type='text/css' /> <!-- Custom google fonts -->
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<!--[if IE]>
<link type="text/css" href="css/ie.css" rel="stylesheet" />
<![endif]-->

<!-- Javascripts -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.rotate.2.1.js"></script>
<script type="text/javascript" src="js/form/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/form/jquery.checkbox.js"></script>
<script type="text/javascript" src="js/form/jquery.defaultvalue.js"></script>

<script type="text/javascript" src="js/login.js"></script>

</head>

<body class="loginPage">
<div class="loginWrapper">
	<div class="logo">
		<a href="login.html">
			<img src="images/dark/logo.png" alt="logo" /><br/><br/>
			<span class="head">微薄管理平台</span>
			<span class="subhead">version 0.1</span>
		</a>
	</div>
	<div class="border">
		<div class="formWrapper">
			<form class="form" action="<?php echo $this->createUrl( 'user' , 'signin' );?>" method="post" id="loginForm">
				<ul>
					<li><input type="text" id="email" name="email" placeholder="Email" /></li>
					<li>
						<input type="password" id="password" name="password" placeholder="Password" />
						<div class="forgotten"><a href="#">忘记密码</a></div>
					</li>
					<li>
						<div class="checkbox">
							<input type="checkbox" name="rememberme" value="1" class="styled" />
						</div>
						<label for="rememberme"><span>记住我</span></label>
					</li>
                    <li><input type="submit" class="button black" value="登陆到微薄管理平台" /></li>
				</ul>
			</form>
		</div>
	</div>
</div>	


</body>
</html>