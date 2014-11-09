<?php
/*
 * @authors 罗敏敏 (adomin@163.com)
 * @date    2014-03-22 23:18:38
 * @文档说明
 */

define('IN_TG',"任意东西");  //定义一个常量 这句一定要写在下面判断之前
define("SCRIPT","active");

if(!defined('IN_TG')){       //如果”IN_TG“这个常量之前没定义过 就退出程序 并输出Access Denied 
	exit('Access Denied!');    //这样就只有通过index.php这一级别的文档才能调用/includes/header.inc.php等文件了 因为只有index.php这一级别的文档才定义了这个常量
}                            //在header.inc.php里写也写上这个判断 但是不定义常量 这样就无法通过 ../../includes/header.inc.php路径直接访问他们了

require dirname(__FILE__).'/includes/common.inc.php';     //转化为硬路径 在common.inc.php中集中配置一些东西

//开始激活处理
if (!isset($_GET['active'])) {
	_alert_back('非法操作');
}
if (isset($_GET['action']) && isset($_GET['active']) && $_GET['action'] == 'ok') {
	$_active = _mysql_string($_GET['active']);
	if (_fetch_array("SELECT tg_active FROM tg_user WHERE tg_active='$_active' LIMIT 1")) {
		//将tg_active设置为空
		mysql_query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
		if (_affected_rows() == 1) {
			mysql_close();
			_location('账户激活成功','login.php');
		} else {
			mysql_close();
			_location('账户激活失败','register.php');
		}
	} else {
		_alert_back('非法操作');
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--激活</title>
	<?php 
		require ROOT_PATH."includes/title.inc.php"      //把三句link都写到title.inc.php里面去
	?>
	<script type="text/javascript" src="js/register.js"></script>
</head>
<body>
 	
	<?php 
		require ROOT_PATH.'includes/header.inc.php';   //在commom.inc.php中定义了常量ROOT_PATH 在这里也用硬路径
	?>
	
	<div id="active">
		<h2>激活账户</h2>
		<p>本页面是为了模拟你的邮件的功能，点击一下的超级链接激活你的账户</p>
		<p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active']?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>active.php?action=ok&amp;active=<?php echo $_GET['active']?></a></p>	
	</div>
	
	<?php 
		require ROOT_PATH.'includes/footer.inc.php';
	?>

</body>
</html>

