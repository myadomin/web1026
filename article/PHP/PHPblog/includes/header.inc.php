<?php 
	if(!defined("IN_TG")){
		exit("Access Denied");
	}
?>
<div id="header">
	<h1><a href="index.php">瓢城Web俱乐部多用户留言系统</a></h1>
	<ul>
		<li><a href="index.php">首页</a></li>
		<?php
		if(isset($_COOKIE['username'])){
			echo '<li><a href="member.php">'.$_COOKIE['username'].'-个人中心</a></li>';
		}else{
			echo '<li><a href="register.php">注册</a></li>';
			echo "\n";
			echo '<li><a href="login.php">登录</a></li>';	
		}
		?>
		<li><a href="blog.php">博友</a></li>
		<li><a href="photo.php">相册</a></li>
		<li><a href="##">风格</a></li>
		<?php
		if(isset($_COOKIE['username']) && isset($_SESSION['manage'])){ //如果登陆了 而且具备管理员session 记得相应页面开启session
			echo '<li><a href="manage.php">管理</a></li> ';  //那就显示 管理
		}
		if(isset($_COOKIE['username'])){     //用户登陆了 才会有退出这两个字 如果点击了这个退出 就情况了cookie就不会显示这个退出了
			echo '<li><a href="logout.php">退出</a></li>'; //点击退出 跳到logout.php
		}
		?>
	</ul>
</div>
