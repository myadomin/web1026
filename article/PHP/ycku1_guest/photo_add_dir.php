<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_add_dir');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//必须是管理员才能登录
is_admin();


//添加目录
if($_GET['action'] == 'adddir'){
	include 'includes/check.inc.php';
	//接收数据
	$clean = array();
	$clean['name'] = check_username($_POST['name']);
	$clean['type'] = $_POST['type'];
	$clean['password'] = sha1($_POST['password']);
	$clean['content'] = check_content($_POST['content']);
	$clean['dir'] = time();
	
	//先检查目录是否存在  然后创建主目录及时间戳子目录
	if(!is_dir('photo')){
		mkdir('photo', 0777);
	}
	if(!is_dir('photo/'.$clean['dir'])){
		mkdir('photo/'.$clean['dir'], 0777);
	}
	
	//有密码 无密码 两种添加 注意sha1(空)不为空
	if(empty($_POST['password'])){
		mysql_query("
				INSERT INTO dir (name, type, content, dir, date)
				VALUES ('{$clean['name']}', '{$clean['type']}', '{$clean['content']}', 'photo/{$clean['dir']}', NOW())
				") or die(mysql_error());
	}else{
		mysql_query("
				INSERT INTO dir (name, type, password, content, dir, date)
				VALUES ('{$clean['name']}', '{$clean['type']}', '{$clean['password']}', '{$clean['content']}', 'photo/{$clean['dir']}', NOW())
				") or die(mysql_error());
	}
	
	//判断添加是否成功
	if(mysql_affected_rows() == 1){
		alert_location('相册添加成功', 'photo.php');
	}else{
		alert_back('相册添加失败');
	}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--添加相册目录</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/photo_add_dir.js"></script>
</head>
<body>

<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<h2>添加相册目录</h2>
	<form method="post" action="?action=adddir">
	<dl>
		<dd>相册名称：<input type="text" name="name" class="text" /></dd>
		<dd>相册类型：<input type="radio" name="type" value="0" checked="checked" /> 公开 <input type="radio" name="type" value="1" /> 私密</dd>
		<dd id="pass">相册密码：<input type="password" name="password" class="text" /></dd>
		<dd>相册描述：<textarea name="content"></textarea></dd>
		<dd><input type="submit" class="submit" value="添加目录" /></dd>
	</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
