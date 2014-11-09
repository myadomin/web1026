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
header("Content-type:text/html;charset=utf-8");

//通过下面的隐藏input得到id 得到修改的内容 将这些修改的内容 更新到对于这个id的数据库那行 然后跳到photo.php给到他们显示
if($_GET['action'] == 'modify'){
	//根据填写的东西 post表单到这里 写入数据库
	mysql_query("
		UPDATE
			tg_dir
		SET
			tg_name = '{$_POST['name']}',
			tg_type = '{$_POST['type']}',
			tg_face = '{$_POST['face']}',
			tg_password = '{$_POST['password']}',
			tg_content = '{$_POST['content']}'
		WHERE
			tg_id = '{$_POST['id']}'
		LIMIT
			1
	");	
	//判断写入是否成功
	if (_affected_rows() == 1) {
		mysql_close();
		_location('目录修改成功','photo.php');
	} else {
		mysql_close();
		_alert_back('目录修改失败！');
	}
	 
}


//读取原来的相册名称 相册类型 相册封面 相册内容等信息 显示为修改前的原始值
if(isset($_GET['id'])){
	$_result = mysql_query("
			SELECT 
				tg_id,tg_name, tg_type, tg_face, tg_content
			FROM
				tg_dir
			WHERE
				tg_id='{$_GET['id']}'
			LIMIT
				1
			");
	if(!$_result){
		_alert_back('不存在此相册');
	}
	$_rows = mysql_fetch_array($_result);
	$_clean = array();
	$_clean['id'] = $_rows['tg_id'];
	$_clean['name'] = $_rows['tg_name'];
	$_clean['type'] = $_rows['tg_type'];
	$_clean['face'] = $_rows['tg_face'];
	$_clean['content'] = $_rows['tg_content'];	
}else{
	_alert_back('非法操作');
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
	<h2>修改相册目录</h2>
	<form method="post" action="?action=modify">
	<dl>
		<dd>
			相册名称：
			<input type="text" name="name" class="text" value="<?php echo $_clean['name'] ?>" />
		</dd>
		<dd>
			相册类型：
			<input type="radio" name="type" value="0" <?php if(!$_clean['type']){echo 'checked="checked"';}?> /> 公开 
			<input type="radio" name="type" value="1" <?php if($_clean['type']){echo 'checked="checked"';}?>/> 私密
		</dd>
		<dd id="pass" <?php if($_clean['type']){echo 'style="display:block"';} ?>>
			相册密码：
			<input type="password" name="password" class="text" value='' />
		</dd>
		<dd>
			相册封面： 
			<input type="text" name="face" value="<?php echo $_clean['face'] ?>" class="text" />
		</dd>
		<dd>相册描述：
			<textarea name="content"><?php echo $_clean['content'] ?></textarea>
		</dd>
		<dd><input type="submit" class="submit" value="修改目录" /></dd>
	</dl>
	<input type="hidden" value="<?php echo $_clean['id'] ?>" name="id" />
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
