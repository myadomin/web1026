<?php

//防止恶意调用
if(!defined("IN_TG")){
	exit("Access Denied");
}

?>

<!--[if lte IE 7]> 
<script type="text/javascript"> 
	alert('不支持IE6 IE7，请用其他浏览器访问'); 
	window.opener=null; 
	window.open('','_self','');
	window.close(); 
</script>
<![endif]-->

<div id="header">
	<ul>
		<li><a href="index.php">首页</a></li>
		<li><a href="list.php?category=javascript">javascript</a></li>
		<li><a href="list.php?category=jQuery">jQuery</a></li>
		<li><a href="list.php?category=Ajax">Ajax</a></li>
		<li><a href="list.php?category=HTML5">HTML5</a></li>
		<li><a href="list.php?category=PHP">PHP</a></li>
		<li><a href="list.php?category=display">web相关</a></li>
		<li><a href="#">项目展示</a></li>
		<li><a href="about.php">关于本站</a></li>
		<li><a href="https://github.com/myadomin?tab=repositories" target="_blank" style="color:red">my github</a></li>
		<!-- <li class="right">www.web1026.com</li> -->
	</ul>
</div>