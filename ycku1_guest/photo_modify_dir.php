<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_add_dir');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//这张页面必须是管理员才能登陆的
is_admin();

//本页点击修改  表单post数据到这里  根据post过来的id修改数据库  然后跳到photo
if($_GET['action'] == 'modify'){
	$password = sha1($_POST['password']);
	if(empty($_POST['password'])){
		mysql_query("
			UPDATE dir
			SET name = '{$_POST['name']}', 
				type = '{$_POST['type']}', 
				content = '{$_POST['content']}', 
				face = '{$_POST['face']}',
				password = null
			WHERE id='{$_POST['id']}'
			LIMIT 1
		") or die(mysql_error());
	}else{
		mysql_query("
			UPDATE dir
			SET name = '{$_POST['name']}', 
				type = '{$_POST['type']}', 
				content = '{$_POST['content']}', 
				face = '{$_POST['face']}', 
				password = '{$password}'
			WHERE id='{$_POST['id']}'
			LIMIT 1
		") or die(mysql_error());
	}
	if(mysql_affected_rows() == 1){
		alert_location('修改成功', 'photo.php');
	}else{
		alert_back('修改失败');
	}
	
}

//根据photo.php get过来的id值  读取数据
if(isset($_GET['id'])){
	$result = mysql_query("
			SELECT name, type, content, face, id
			FROM dir
			WHERE id = '{$_GET['id']}'
			LIMIT 1
			") or die(mysql_error());
	if(!$rows = mysql_fetch_array($result)){
		alert_back('不存在此相册');
	}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--修改相册目录</title>
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
	<h2>修改相册目录</h2>
	<form method="post" action="?action=modify">
	<dl>
		<dd>相册名称：<input type="text" name="name" class="text" value="<?php echo $rows['name']?>" /></dd>
		<dd>相册类型：<input type="radio" name="type" value="0" <?php if ($rows['type'] == 0) echo 'checked="checked"'?> /> 公开 <input type="radio" name="type" value="1" <?php if ($rows['type'] == 1) echo 'checked="checked"'?> /> 私密</dd>
		<dd id="pass" <?php if ($rows['type'] == 1) echo 'style="display:block;"'?>>相册密码：<input type="password" name="password" class="text" /></dd>
		<dd>相册封面：<input type="text" name="face" value="<?php echo $rows['face']?>" class="text" /></dd>
		<dd>相册描述：<textarea name="content"><?php echo $rows['content']?></textarea></dd>
		<dd><input type="submit" class="submit" value="修改目录" /></dd>
	</dl>
	<input type="hidden" value="<?php echo $rows['id']?>" name="id" />
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
