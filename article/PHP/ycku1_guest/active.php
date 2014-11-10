<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);

//定义个常量，用来指定本页的内容
define('SCRIPT','active');

//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

if(!isset($_GET['active'])){
	alert_back('不能直接进这个页面，必须是点击激活链接跳到这里');
}

//开始激活处理
//在register.php注册通过后 get发送active字段值给到本页面的a链接作为?active=xxxx
//点击本页面的a链接发送$_GET['active']到这里  判断这个发送是否等同于register写入数据库的active字段值
//从而确保注册信息一定是register.php完成并写入数据库的  而不是别人伪造的注册页面
//如果激活成功  就让active字段值在数据库清空  后续只有active字段值是空的才能登录
if(isset($_GET['active']) && $_GET['action'] == 'ok'){
	$result = mysql_query("SELECT active FROM user WHERE active='{$_GET['active']}' LIMIT 1");
	if(mysql_fetch_array($result)){
		mysql_query("UPDATE user SET active=NULL WHERE active='{$_GET['active']}' LIMIT 1");
		if(mysql_affected_rows()){
			mysql_close();
			alert_location('账户激活成功', 'login.php');
		}else{
			mysql_close();
			alert_location('账户激活失败', 'register.php');
		}
	}else{
		alert_location('账户激活失败', 'register.php');
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--激活</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="active">
	<h2>激活账户</h2>
	<p>本页面是为了模拟您的邮件的功能，点击以下超级连接激活您的账户</p>
	<p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active']?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>?action=ok&amp;active=<?php echo $_GET['active']?></a></p>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

