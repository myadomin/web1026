<?php 

define('IN_TG', '可以调用');
require dirname(__FILE__).'/includes/common.inc.php';

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首页</title>
<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/index.css" />
</head>
<body>

<?php 
require ROOT_PATH.'includes/header.inc.php';
?>

<div id="top">
	<h2>首页</h2>
	<h4>web前端开发个人技术博客<br />DEMO都带演示，源代码，原理分析，代码下载<br /></h4>
</div>

<div id="bar">
	<ul>
		<li class="li1">首页</li>
	</ul>
</div>

<div id="content">
	<dl>
		<dt class="dt1"><a href="list.php?category=javascript">javascript</a></dt>
		<dd class="dd1">JS各个知识点的原理DEMO，各种DOM操作效果DEMO，JS面向对象，JS组件开发，JS模块化开发，封装常用函数库等。</dd>
		<dd class="dd2"><a href="list.php?category=javascript">查看博文</a></dd>
	</dl>
	<dl>
		<dt class="dt2"><a href="list.php?category=jQuery">jQuery</a></dt>
		<dd class="dd1">jQuery基础笔记，jQuery实例DEMO，jQuery源码分析等。</dd>
		<dd class="dd2"><a href="list.php?category=jQuery">查看博文</a></dd>
	</dl>
	<dl>
		<dt class="dt3"><a href="list.php?category=Ajax">Ajax</a></dt>
		<dd class="dd1">Ajax封装及应用，Ajax瀑布流，Ajax获取后端数据的应用，JSONP应用等。</dd>
		<dd class="dd2"><a href="list.php?category=Ajax">查看博文</a></dd>
	</dl>
	<dl>
		<dt class="dt4"><a href="list.php?category=HTML5">HTML5</a></dt>
		<dd class="dd1">HTML5各知识点DEMO，canvas应用及游戏，LBS应用，CSS3响应式布局及2D及3D操作等。</dd>
		<dd class="dd2"><a href="list.php?category=HTML5">查看博文</a></dd>
	</dl>
	<dl>
		<dt class="dt6"><a href="list.php?category=PHP">PHP</a></dt>
		<dd class="dd1">PHP基础笔记，PHP各知识点DEMO，mysql及mysqli的应用，PHP面向对象，如果构建PHP API等。</dd>
		<dd class="dd2"><a href="list.php?category=PHP">查看博文</a></dd>
	</dl>
	<dl>
		<dt class="dt7"><a href="list.php?category=display">WEB相关</a></dt>
		<dd class="dd1">css布局展示，服务器环境搭建，工具使用，web优化等web相关笔记。</dd>
		<dd class="dd2"><a href="list.php?category=display">查看博文</a></dd>
	</dl>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>

</body> 
</html>    
      
     
     
     