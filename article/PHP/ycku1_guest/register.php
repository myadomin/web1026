<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义需要引入的专有css js
define("SCRIPT", "register");
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//如果已登录就不能进入这个页面
is_login();

//后台是否启用了开发注册
if(!SYS_REGISTER){
	alert_back('还未开放注册');
}

//如果是表单提交
if($_GET['action'] == 'register'){
	//验证验证码
	check_code($_POST['code'], $_SESSION['code']);
	
	//引入验证函数库
	include ROOT_PATH.'includes/check.inc.php';
	
	//准备存入数据库的数据
	$clean = array();
	//唯一标示符验证  post过来的唯一标示符必须是本机生成的唯一标示符  防止伪装post表单
	$clean['uniqid'] = check_uniqid($_POST['uniqid'], $_SESSION['uniqid']);
	//激活用的唯一标示符
	$clean['active'] = get_uniqid();
	//post表单的字段值验证
	$clean['username'] = check_username($_POST['username'], 3, 20);
	$clean['password'] = check_password($_POST['password'], $_POST['notpassword']);
	$clean['passt'] = check_passt($_POST['passt']);
	$clean['passd'] = check_passd($_POST['passd'], $_POST['passt']);
	$clean['sex'] = $_POST['sex'];
	$clean['face'] = $_POST['face'];
	$clean['email'] = check_email($_POST['email']);
	$clean['qq'] = check_qq($_POST['qq']);
	$clean['url'] = check_url($_POST['url']);
// 	print_r($clean);
	
	//在新增之前判断用户名是否重复
	$result = mysql_query("SELECT username FROM user WHERE username='{$clean['username']}' LIMIT 1");
	if(mysql_fetch_array($result)){
		alert_back('此用户已被注册');
	}
	
	//新增表单字段值到数据库  对于变量注意'{xxx}'
	mysql_query("
			INSERT INTO 
			user(
				uniqid,
				active,
				username,
				password,
				passt,
				passd,
				sex,
				face,
				email,
				qq,
				url,
				reg_time,
				last_time,
				last_ip
			) 
			VALUES(
				'{$clean['uniqid']}',
				'{$clean['active']}',
				'{$clean['username']}',
				'{$clean['password']}',
				'{$clean['passt']}',
				'{$clean['passd']}',
				'{$clean['sex']}',
				'{$clean['face']}',
				'{$clean['email']}',
				'{$clean['qq']}',
				'{$clean['url']}',
				NOW(),
				NOW(),
				'{$_SERVER["REMOTE_ADDR"]}'
			)
	") or die('失败'.mysql_error());
	
	//跳转
	if(mysql_affected_rows() == 1){
		//得到新生成用户的id
		$clean['id'] = mysql_insert_id();
		//生成保存此用户信息的xml 此用户永远是最新用户
		set_xml('new.xml', $clean);
		alert_location('恭喜注册成功', 'active.php?active='.$clean['active']);
	}else{
		alert_location('注册失败', 'register.php');		
	}
}else{
	//刚刷新进入页面还没提交表单的时候  生成唯一标示符并存入session
	$_SESSION['uniqid'] = $uniqid = get_uniqid();
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--注册</title>
<?php include ROOT_PATH.'includes/title.inc.php'; ?>
<script type="text/javascript" src="js/register.js"></script>
</head>
<body>

<?php 
require ROOT_PATH.'includes/header.inc.php';
?>

<div id="register">
	<h2>会员注册</h2>
	<form method="post" action="register.php?action=register">
		<input type="hidden" name="uniqid" value="<?php echo $uniqid ?>" />
		<dl>
			<dt>请认真填写一下内容</dt>
			<dd>用 户 名：<input type="text" name="username" class="text" />(*必填，至少三位)</dd>
			<dd>密　　码：<input type="password" name="password" class="text" />(*必填，至少六位)</dd>
			<dd>确认密码：<input type="password" name="notpassword" class="text" />(*必填，同上)</dd>
			<dd>密码提示：<input type="text" name="passt" class="text" />(*必填，至少两位)</dd>
			<dd>密码回答：<input type="text" name="passd" class="text" />(*必填，至少两位)</dd>
			<dd>性　　别：<input type="radio" name="sex" value="男" checked="checked" />男 <input type="radio" name="sex" value="女" />女</dd>
			<dd id="face"><input type="hidden" name="face" value="face/m01.gif" id="faceinput"/><img src="face/m01.gif" alt="头像选择" id="faceimg" /></dd>
			<dd>电子邮件：<input type="text" name="email" class="text" /></dd>
			<dd>　Q Q 　：<input type="text" name="qq" class="text" /></dd>
			<dd>主页地址：<input type="text" name="url" class="text" value="http://" /></dd>
			<dd>验 证 码：<input type="text" name="code" class="text yzm" /><img src="code.php" id="code"/></dd>
			<dd><input type="submit" class="submit" value="注册" /></dd>
		</dl>
	</form>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
