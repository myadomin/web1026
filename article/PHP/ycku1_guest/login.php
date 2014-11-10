<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','login');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//如果已登录就不能进入这个页面
is_login();

//开始处理登录状态
if ($_GET['action'] == 'login') {
	//验证验证码
	check_code($_POST['yzm'], $_SESSION['code']);
	
	//验证用户名和密码是否匹配  并且已经激活过(也就是active字段值是空)
	$username = $_POST['username'];
	$password = sha1($_POST['password']);
	$time = $_POST['time'];
	$result = mysql_query("
			SELECT username, uniqid, level
			FROM user 
			WHERE username='{$username}'
			AND password = '{$password}'
			AND active = ''
			LIMIT 1
	") or die('失败：'.mysql_error());
	
	//如果读取了1条数据  就说明匹配  登录成功
	if(!!$rows = mysql_fetch_array($result)){
		//登录成功跳转前  存储cookie 记录登录次数
		set_cookie($rows['username'], $rows['uniqid'], $time);
		//判断是否为管理员登录 如果是就设置session
		if($rows['level']){
			$_SESSION['admin'] = $rows['username'];
		}
		//更新某些字段
		mysql_query("
			UPDATE user
			SET last_time = NOW(), last_ip = '{$_SERVER["REMOTE_ADDR"]}', login_count = login_count+1
			WHERE username='{$username}'	
		");
		alert_location(NULL, 'member.php');
	}else{
		alert_location('用户名或者密码错误，或者没激活', 'login.php');
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--登录</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="login">
	<h2>登录</h2>
	<form method="post" name="login" action="login.php?action=login">
		<dl>
			<dt></dt>
			<dd>用 户 名：<input type="text" name="username" class="text" /></dd>
			<dd>密　　码：<input type="password" name="password" class="text" /></dd>
			<dd>保　　留：<input type="radio" name="time" value="0" checked="checked" /> 不保留 <input type="radio" name="time" value="1" /> 一天 <input type="radio" name="time" value="2" /> 一周 <input type="radio" name="time" value="3" /> 一月</dd>
			<dd>验 证 码：<input type="text" name="yzm" class="text code"  /> <img src="code.php" id="code" /></dd>
			<dd><input type="submit" value="登录" class="button" /> <input type="button" value="注册" id="location" class="button location" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

