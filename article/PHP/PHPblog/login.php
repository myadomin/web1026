<?php
define('IN_TG',"任意东西");  //定义一个常量 这句一定要写在下面判断之前
define("SCRIPT","login");
if(!defined('IN_TG')){       //如果”IN_TG“这个常量之前没定义过 就退出程序 并输出Access Denied 
	exit('Access Denied!');  //这样就只有通过index.php这一级别的文档才能调用/includes/header.inc.php等文件了 因为只有index.php这一级别的文档才定义了这个常量
}
session_start();
header("Content-type:text/html;charset=utf-8");  
require dirname(__FILE__).'/includes/common.inc.php';     //转化为硬路径 在common.inc.php中集中配置一些东西
_login_status();             //登录状态下 如果有人直接通过register.php或者login.php进入登录或注册页面 不能进入

if($_GET["action"] == "login"){  
//下面的表单method="post"就是内部input的name value通过post发送  
//action="login.php?action=login" 就是点击提交后发送的url值 而这个是get形式 所以可以用上面的判断
	_check_code($_POST["code"],$_SESSION["code"]);
	include ROOT_PATH."includes/login.func.php";
	$_clean = array();
	$_clean["username"] = _check_username($_POST["username"],2,20); 
	$_clean["password"] = _check_password($_POST["password"],6);
	$_clean["time"] = _check_time($_POST["time"]);
	//print_r($_clean);
	//得到后 去数据库验证这些信息
	//查找数据库的一行 这行的tg_username tg_password等于登陆输入的值  并且这行的tg_active为空（也就是激活过）得到tg_username tg_uniqid 
	if(!!$_rows = _fetch_array("SELECT tg_level, tg_username,tg_uniqid FROM tg_user WHERE tg_username='{$_clean["username"]}' and tg_password='{$_clean["password"]}' and tg_active='' LIMIT 1")){
		//用户每次成功登陆 登陆次数加一次 并记录到数据库
		mysql_query("
				UPDATE 
					tg_user 
				SET 
					tg_last_time = NOW(),
					tg_last_ip = '{$_SERVER["REMOTE_ADDR"]}',
					tg_login_count = tg_login_count + 1
				WHERE 
					tg_username = '{$_rows['tg_username']}'	
				");
		mysql_close();
		if($_rows['tg_level'] == 1){  //如果登陆的人 tg_level字段 是1 那就是管理员 开启管理员session 记得后续相应页面开启session
			$_SESSION['manage'] = $_clean["username"];
		}
		_setcookies($_rows['tg_username'], $_rows['tg_uniqid'], $_clean["time"]); 
		//如果登陆成功 就设置cookie 设置名称为username的值为登录名 设置过期时间为第三个参数 选择的raido 然后header部分判断生成不同的页面
		_location("登录成功", "member.php");
	}else{
		mysql_close();
		_location("用户名密码不正确或者改用户没注册或者没激活", "login.php");
	}
}

?>     


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--注册</title>
<?php 
	require ROOT_PATH."includes/title.inc.php"      //把三句link都写到title.inc.php里面去
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/login.js"></script>
</head>
<body>

<?php 
	require ROOT_PATH.'includes/header.inc.php';   //在commom.inc.php中定义了常量ROOT_PATH 在这里也用硬路径
?>

<div id="login">
	<h2>登录</h2>           
	<form method="post" name="login" action="login.php?action=login" > 
		<dl>
			<dt>　</dt>
			<dd>用 户 名：<input type="text" name="username" class="text" /></dd>
			<dd>密　　码：<input type="password" name="password" class="text" /></dd>
			<dd>保　　留：
				<input name="time" value="0" type="radio" checked="checked" /> 不保留
				<input name="time" value="1" type="radio" /> 一天
				<input name="time" value="2" type="radio" /> 一周
				<input name="time" value="3" type="radio" /> 一月
			</dd>
			<dd>验 证 码：<input type="text" name="code" class="text code"/><img src="code.php" id="code"/></dd>
			<dd>
				<input type="submit" value="登录" class="button" />
				<input type="button" value="注册" class="button location" />
			</dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?> 

</body> 
</html>    
      
     
     
     