<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','message');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");
session_start();

//先要登录 如果没登录 关闭窗口
if(!isset($_COOKIE['username'])){
	_alert_close('请先登录');
}

//短信界面的信息发送验证  一旦点击了发送 就执行这段 并且下面的也不需要执行了 所以最后无论是否发送成功都exit()了
if($_GET['action'] == 'write'){
	//获取数据 并且验证 另外js中也会做一次验证
	_check_code($_POST["code"],$_SESSION["code"]);
	$_result = mysql_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
	$_rows = mysql_fetch_array($_result);
	if($_rows['tg_uniqid'] != $_COOKIE['uniqid']){  //数据库存储的唯一标示符 如果和之前cookie存的标示符不一致  说明伪造了cookie
		_alert_back('唯一标示符异常');
	}
	include ROOT_PATH."includes/register.func.php";
	$_clean = array();
	$_clean['touser'] = $_POST['touser'];
	$_clean['fromuser'] = $_COOKIE['username'];
	$_clean['content'] = _check_content($_POST['content'], 10, 200);
	//新增到数据库
	mysql_query("INSERT INTO tg_message(
				tg_touser,
				tg_fromuser,
				tg_content,
				tg_date
			) 
			VALUES(
				'{$_clean['touser']}',
				'{$_clean['fromuser']}',
				'{$_clean['content']}',
				NOW()
			)");
	//判断是否新增成功
	if(_affected_rows() == 1){
		mysql_close();  
		_session_destory();
		_alert_close("恭喜你，发送成功");  
	}else{
		mysql_close();
		_session_destory();
		_alert_back("很遗憾，发送失败");
	}
}

//获取数据 给到TO XXX
if(isset($_GET['id'])){
	//通过?id=xx $_GET['id']得到了某个指定用户的tg_id 通过这个用户的tg_id查找他的tg_username
	$_result = mysql_query("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1");
	if(!!$_rows = mysql_fetch_array($_result)){ 
		$_toUsername = $_rows['tg_username'];     //把这个变量 给到TO XXX
	}else{
		_alert_close('不存在此用户');	  //如果一行数据都获取不到 那就是此用户在数据库中被删除了
	}
}else{
	_alert_close('非法操作');  //如果进到这里 说明用户不是通过点击发消息按钮开的子窗口 而是自己输入网址 自己开的小窗口 这个不允许
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--写短信</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/message.js"></script>
</head>
<body>

<div id="message">
	<h3>写短信</h3>
	<form method="post" action="message.php?action=write">
		<input type="hidden" name="touser" value="<?php echo $_toUsername ?>" />
		<dl>
			<dd><input type="text" readonly="readonly" value="TO:<?php echo $_toUsername?>" class="text" /></dd>
			<dd><textarea name="content"></textarea></dd>
			<dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="发送短信" /></dd>
		</dl>
	</form>
</div>

</body>
</html>
