<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//没登陆的不能进入个人中心
if(!$_COOKIE['username']){
	alert_back('请先登录');
}

//通过cookie知道当前是哪个用户
$result = mysql_query("
			SELECT username, sex, face, email, url, qq, reg_time, level
			FROM user
			WHERE username='{$_COOKIE['username']}'
		");

//得到结果数组
$rows = mysql_fetch_array($result, MYSQL_ASSOC);
if(!$rows){
	alert_back('此用户不存在');
}

//通过htmlspecialchars 把< >等特殊字符转义  从而不影响html
$html = array();
$html['username'] = htmlspecialchars($rows['username']);
$html['sex'] = htmlspecialchars($rows['sex']);
$html['face'] = htmlspecialchars($rows['face']);
$html['email'] = htmlspecialchars($rows['email']);
$html['url'] = htmlspecialchars($rows['url']);
$html['qq'] = htmlspecialchars($rows['qq']);
$html['reg_time'] = htmlspecialchars($rows['reg_time']);
switch($rows['level']){
	case '0':
		$html['level'] = '普通会员';
		break;
	case '1':
		$html['level'] = '管理员';
		break;
	default:
		$html['level'] = '出错了';
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--个人中心</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="member">
	<?php 
		require ROOT_PATH.'includes/member.inc.php';
	?>
	<div id="member_main">
		<h2>会员管理中心</h2>
		<dl>
			<dd>用 户 名：<?php echo $html['username'] ?></dd>
			<dd>性　　别：<?php echo $html['sex'] ?></dd>
			<dd>头　　像：<?php echo $html['face'] ?></dd>
			<dd>电子邮件：<?php echo $html['email'] ?></dd>
			<dd>主　　页：<?php echo $html['url'] ?></dd>
			<dd>Q 　 　Q：<?php echo $html['qq'] ?></dd>
			<dd>注册时间：<?php echo $html['reg_time'] ?></dd>
			<dd>身　　份：<?php echo $html['level'] ?></dd>
		</dl>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
