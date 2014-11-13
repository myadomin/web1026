<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_add_img');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//这张页面必须会员
if (!$_COOKIE['username']) {
	alert_back('请先登录！');
}


//将图片信息保存到数据库  必须写前面   跳转到带id的photo_show.php
if($_GET['action'] == 'addimg'){
	//接收数据
	include 'includes/check.inc.php';
	$clean = array();
	$clean['name'] = check_username($_POST['name']);
	$clean['url'] = check_no_empty($_POST['url']);
	$clean['content'] = $_POST['content'];
	$clean['sid'] = $_POST['sid'];
	
	//写入数据库
	mysql_query("
			INSERT INTO photo (name, url, content, sid, username, date)
			VALUES ('{$clean['name']}', '{$clean['url']}', '{$clean['content']}', '{$clean['sid']}', '{$_COOKIE['username']}', NOW())
			") or die(mysql_error());
	if(mysql_affected_rows() == 1){
		alert_location('添加图片成功', 'photo_show.php?id='.$clean['sid']);
	}else{
		alert_back('添加图片失败');
	}
}


//接收photo_show.php传过来的id 读取数据库得到dir 通过js传递dir到upimg.php
if(isset($_GET['id'])){
	$result = mysql_query("
			SELECT id, dir
			FROM dir
			WHERE id='{$_GET['id']}'
			LIMIT 1
			");
	if(!$rows = mysql_fetch_array($result)){
		alert_back('非法id');
	}
}else{
	alert_back('非法操作');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--上传图片</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/photo_add_img.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<h2>上传图片</h2>
	<form method="post" action="?action=addimg">
	<dl>
		<dd>图片名称： <input type="text" name="name" class="text" /></dd>
		<dd>图片地址：
			<input type="text" name="url" readonly="readonly" class="text" id="url"/> 
			<a href="javascript:;" id="up" title="<?php echo $rows['dir']?>">上传</a>
		</dd>
		<dd>图片描述： <textarea name="content"></textarea></dd>
		<dd><input type="submit" class="submit" value="添加图片" /></dd>
	</dl>
	<input type="hidden" name="sid" value="<?php echo $rows['id']?>"/>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
