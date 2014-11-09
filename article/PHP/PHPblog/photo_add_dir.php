<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_add_dir');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//这张页面必须是管理员才能登陆的
_manage_login();

//写入数据库 js验证过后 然后发送表单提交 到这里
if($_GET['action'] == 'adddir'){
	//接收表单POST的数据 php验证就不做了
	$_clean = array();
	$_clean['name'] = $_POST['name'];
	$_clean['type'] = $_POST['type'];
	$_clean['password'] = sha1($_POST['password']);
	$_clean['content'] = $_POST['content'];
	$_clean['dir'] = time();
	//创建文件夹	
	if(!is_dir('photo')){       //如果此文件同级别 没有文件夹photo
		mkdir('photo', 0777);   //那就创建文件夹photo
	}
	if(!is_dir('photo/'.$_clean['dir'])){
		mkdir('photo/'.$_clean['dir']);  //在photo文件夹下 再创建一个文件夹 名称是当前时间戳
	}
	//写入数据库
	if($_clean['type']){       //如果是1的话 就有密码
		mysql_query("INSERT INTO tg_dir (
										tg_name,
										tg_type,
										tg_password,
										tg_content,
										tg_dir,
										tg_date
										)
								VALUES
										(
										'{$_clean['name']}',
										'{$_clean['type']}',
										'{$_clean['password']}',
										'{$_clean['content']}',
										'photo/{$_clean['dir']}',
										NOW()
										)
		");
	}else{
		mysql_query("INSERT INTO tg_dir (
										tg_name,
										tg_type,
										tg_content,
										tg_dir,
										tg_date
										)
								VALUES
										(
										'{$_clean['name']}',
										'{$_clean['type']}',
										'{$_clean['content']}',
										'photo/{$_clean['dir']}',
										NOW()
										)
		");
	}
	//判断是否写入成功
	if (_affected_rows() == 1) {
		mysql_close();
		_location('相册添加成功','photo.php');
	} else {
		mysql_close();
		_alert_back('相册添加失败');
	}
	
	
}




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
