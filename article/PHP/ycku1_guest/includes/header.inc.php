<?php 
//如果没有定义过常量IN_TG 那就退出 防止恶意调用
if(!defined("IN_TG")){
	exit('Access Denied');
}

//未读短信数提醒
$result_count = mysql_query("
	SELECT COUNT(id)
	AS count
	FROM message
	WHERE touser='{$_COOKIE['username']}' AND status=0
") or die(mysql_error());
$rows_count = mysql_fetch_array($result_count);
if(empty($rows_count['count'])){
	$count_html = '<strong>(0)</strong>';
}else{
	$count_html = '<strong>('.$rows_count['count'].')</strong>';
}
?>
<script type="text/javascript" src="js/skin.js"></script>
<div id="header">
	<h1><a href="index.php">多用户留言系统</a></h1>
	<ul>
		<li><a href="index.php">首页</a></li>
		<?php 
		if(isset($_COOKIE['username'])){
			echo '<li><a href="member.php">'.$_COOKIE['username'].'-个人中心'.$count_html.'</a></li>';		
		}else{
			echo '<li><a href="register.php">注册</a></li> ';
			echo '<li><a href="login.php">登录</a></li>';
		}
		?>
		<li><a href="blog.php">博友</a></li>
		<li><a href="photo.php">相册</a></li>
		<li class="skin" onmouseover='inskin()' onmouseout='outskin()'>
			<a href="javascript:;">风格</a>
			<dl id="skin">
				<dd><a href="skin.php?id=1">1.一号皮肤</a></dd>
				<dd><a href="skin.php?id=2">2.二号皮肤</a></dd>
				<dd><a href="skin.php?id=3">3.三号皮肤</a></dd>
			</dl>
		</li>
		<?php 
		if(isset($_COOKIE['username']) && isset($_SESSION['admin'])){
			echo '<li><a href="manage.php" class="manage">管理</a></li> ';
		}
		if(isset($_COOKIE['username'])){
			echo '<li><a href="logout.php">退出</a></li>';
		}
		?>
	</ul>
</div>