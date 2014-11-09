<?php 

define('IN_TG', '可以调用');
require dirname(__FILE__).'/includes/common.inc.php';

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>关于</title>
<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/about.css" />
</head>
<body>

<?php 
require ROOT_PATH.'includes/header.inc.php';
?>

<div id="top">
	<h2>关于</h2>
	<h4>代码下载，本站说明，个人说明</h4>
</div>

<div id="bar">
	<ul>
		<li><a href="index.php">首页</a>　/</li>  
		<li class="li1" id="download">关于</li>
	</ul>
</div>

<div id="content">
	<div class="content_left">
		<dl class="dl1">
			<dt>代码下载</dt>
			<dd><a href="download/all.zip">所有源代码下载 [24M]</a></dd>
			<dd>敬请参考</dd>
		</dl>
		<dl class="dl2">
			<dt>本站说明</dt>
			<dd>web前端开发个人技术博客</dd>
			<dd>DEMO都带演示，源代码，原理分析，代码下载</dd>
		</dl>
		<dl class="dl3">
			<dt>个人说明</dt>
			<dd>喜欢前端开发</dd>
			<dd>充满好奇心</dd>
			<dd>生活需要一些乐子</dd>
		</dl>
	</div>
	<!-- <div class="content_right">
		预留
	</div> -->
	<div class="content_bottom"><!-- 在这里清除浮动，然后height:100px --></div>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>

 
</body> 
</html>    
      
     
     
     