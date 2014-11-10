<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','upimg');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//会员才能进入
if (!$_COOKIE['username']) {
	alert_back('请先登录！');
}


//图片上传  通过post过来的dir将图片存入对应的目录  并且把这个路径放入photo_add_img.php的对应表单里
if($_GET['action'] == 'up'){
	//设置上传图片的类型
	$_files = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
	
	//判断类型是否是数组里的一种
	if (is_array($_files)) {
		if (!in_array($_FILES['userfile']['type'],$_files)) {
			alert_back('上传图片必须是jpg,png,gif中的一种！');
		}
	}
	
	//判断文件错误类型
	if ($_FILES['userfile']['error'] > 0) {
		switch ($_FILES['userfile']['error']) {
			case 1: alert_back('上传文件超过约定值1');
			break;
			case 2: alert_back('上传文件超过约定值2');
			break;
			case 3: alert_back('部分文件被上传');
			break;
			case 4: alert_back('没有任何文件被上传！');
			break;
		}
		exit;
	}
	
	//判断配置大小
	if ($_FILES['userfile']['size'] > 1000000) {
		alert_back('上传的文件不得超过1M');
	}
	
	//让文件名变成时间戳.xxx 这样同名的图片就不会被覆盖
	$n = explode('.', $_FILES['userfile']['name']);
	$name = $_POST['dir'].'/'.time().'.'.$n[1];
	
	//移动文件
	if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
		if	(!@move_uploaded_file($_FILES['userfile']['tmp_name'],$name)) {
			alert_back('上传失败');
		} else {
			//上传成功后 将上传地址放入photo_add_img.php的对应表单里
			echo "<script>
					alert('上传成功');
					window.opener.document.getElementById('url').value='".$name."';
					window.close();
				</script>";
		}
	} else {
		alert_back('上传的临时文件不存在！');
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
</head>
<body>

<div id="upimg" style="padding:20px;">
	<form enctype="multipart/form-data" action="upimg.php?action=up" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
		选择图片: <input type="file" name="userfile" />
		<input type="submit" value="上传" />
		<!-- 接收传过来的$_GET['dir'] 作为post表单  本页用$_POST['dir']接收  -->
		<input type="hidden" name="dir" value="<?php echo $_GET['dir']?>"/>
	</form>
</div>

</body>
</html>
