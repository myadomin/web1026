<?php
	define('IN_TG',"任意东西");  //定义一个常量 这句一定要写在下面判断之前
	define("SCRIPT","face");        //定义一个常量 便于调用title.inc.php
	
	if(!defined('IN_TG')){       //如果”IN_TG“这个常量之前没定义过 就退出程序 并输出Access Denied
		exit('Access Denied!');    //这样就只有通过index.php这个文档才能调用/includes/header.inc.php等文件了 因为只有index.php才定义了这个常量
	}                            //在header.inc.php里写也写上这个判断 但是不定义常量 这样就无法通过 ../../includes/header.inc.php路径直接访问他们了
	
	require dirname(__FILE__).'/includes/common.inc.php';     //转化为硬路径 在common.inc.php中集中配置一些东西
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--首页</title>
<?php 
	require ROOT_PATH."includes/title.inc.php";    //把三句link都写到title.inc.php里面去
?>
<script type="text/javascript" src="js/opener.js"></script>
</head>
<body>
 
	<div id="face">
		<h3>选择头像</h3>
		<dl>           <!-- 循环创建dd -->
			<?php foreach(range(1,9) as $num){?>                  
			<dd><img src="face/m0<?php echo $num?>.gif" alt="face/m0<?php echo $num?>.gif" title="图片<?php echo $num?>"/></dd>     
			<?php }?>
			<?php foreach(range(10,64) as $num){?>
			<dd><img src="face/m<?php echo $num?>.gif" alt="face/m<?php echo $num?>.gif" title="图片<?php echo $num?>"/></dd>     
			<?php }?>
		</dl>
	</div>

</body>
</html>
