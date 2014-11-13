<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','message');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//如果点击了表单发送  就执行这里  并且后面不执行了
if($_GET['action'] == 'send'){
	//验证验证码
	check_code($_POST['code'], $_SESSION['code']);
	//引入验证函数库
	include ROOT_PATH.'includes/check.inc.php';
	//准备写入数据库的字段值  可能需要mysql转义
	$clean = array();
	$clean['touser'] = mysql_string($_POST['touser']);
	$clean['fromuser'] = mysql_string($_COOKIE['username']);
	$clean['content'] = check_content($_POST['content']);
	$clean['flower'] = $_POST['flower'];
// 	print_r($clean);
	//不能自己送自己
	if($clean['touser'] == $clean['fromuser']){
		alert_close('不能自己送自己花');
	}
	//写入mysql
	mysql_query("
		INSERT INTO flower (touser, fromuser, content, flower, date)
		VALUES ('{$clean['touser']}', '{$clean['fromuser']}', '{$clean['content']}', '{$clean['flower']}', NOW())
	");
	if(mysql_affected_rows() == 1){
		alert_close('送花成功');
	}else{
		alert_back('送花失败');
	}
	exit();
}

//判断是否登录了
if (!isset($_COOKIE['username'])) {
	alert_close('请先登录！');
}
//必须带id进
if(!isset($_GET['id'])){
	alert_back('非法操作');
}

//被点击用户的id通过url传到了这个页面  通过id查找到$tousername
$result = mysql_query("
	SELECT username
	FROM user
	WHERE id='{$_GET['id']}'
	LIMIT 1
");
$rows = mysql_fetch_array($result);
$tousername = $rows['username'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--送花</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/message.js"></script>
</head>
<body>

<div id="message">
	<h3>送花</h3>
	<form method="post" action="?action=send">
	<input type="hidden" name="touser" value="<?php echo htmlspecialchars($tousername)?>" />
	<dl>
		<dd>
			<input type="text" value="TO:<?php echo htmlspecialchars($tousername)?>" class="text" readonly="readonly"/>
			<select name="flower">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
			</select>朵
		</dd>
		<dd><textarea name="content">非常非常的欣赏你，送你一些花，嘿嘿</textarea></dd>
		<dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="送花" /></dd>
	</dl>
	</form>
</div>

</body>
</html>