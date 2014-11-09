<?php
define('IN_TG',"任意东西");
define("SCRIPT","member");
require dirname(__FILE__).'/includes/common.inc.php';
session_start();
//只有登录的产生cookie了才能进入页面  直接通过member.php进入页面是非法登录
if(isset($_COOKIE['username'])){
	$_result = mysql_query("SELECT tg_username, tg_sex, tg_face, tg_email, tg_url, tg_qq, tg_reg_time, tg_level FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
	$_rows = mysql_fetch_array($_result);
// 	echo $_rows['tg_username'];
	if($_rows){   //可能用户登录并cookie保存了一个月 在这一个月内 cookie存在 可是管理员已经删除了此用户的数据库数据 所以要做这个判断
		$_html = array();
		$_html['username'] = htmlspecialchars($_rows['tg_username']);
		$_html['sex'] = htmlspecialchars($_rows['tg_sex']);
		$_html['face'] = htmlspecialchars($_rows['tg_face']);
		$_html['email'] = htmlspecialchars($_rows['tg_email']);
		$_html['url'] = htmlspecialchars($_rows['tg_url']);
		$_html['qq'] = htmlspecialchars($_rows['tg_qq']);
		$_html['reg_time'] = htmlspecialchars($_rows['tg_reg_time']);
		switch($_rows['tg_level']){
			case '0':
				$_html['level'] = '普通用户';
				break;
			case '1':
				$_html['level'] = '管理员';
				break;
			default:
				$_html['level'] = '出错了';
		}	
	}else{
		_alert_back('此用户不存在');
	}
}else{
	_alert_back('非法登录');
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--个人中心</title>
<?php
require ROOT_PATH."includes/title.inc.php";    //把三句link都写到title.inc.php里面去
?>
</head>
<body>
<?php 
require ROOT_PATH.'includes/header.inc.php';   //在commom.inc.php中定义了常量ROOT_PATH 在这里也用硬路径
?>

<div id="member">
	<?php 
	require ROOT_PATH.'includes/member.inc.php';
	?>
	<div id="member_main">
		<h2>会员管理中心</h2>
		<dl>
			<dd>用 户   名：<?php echo $_html['username'] ?></dd>
			<dd>性　　别：<?php echo $_html['sex'] ?></dd>
			<dd>头　　像：<?php echo $_html['face'] ?></dd>
			<dd>电子邮件：<?php echo $_html['email'] ?></dd>
			<dd>主　　页：<?php echo $_html['url'] ?></dd>
			<dd>Q 　 　Q：<?php echo $_html['qq'] ?></dd>
			<dd>注册时间：<?php echo $_html['qq'] ?></dd>
			<dd>身　　份：<?php echo $_html['level'] ?></dd>
		</dl>
	</div>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
















