<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','upimg');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");
//会员才能进入
if (!$_COOKIE['username']) {
	_alert_back('非法登录！');
}

//从photo.php点击相册封面 进入photo_show.php 然后点击上传图片 进入photo_add_img.php 然后点击旁边的上传 通过js进入到upimg.php
//从photo.php点击相册封面 进入photo_show.php 同时?过来了id 判断如果是传过来的id才操作 否则不能进入这个页面 非法操作
//而且传过来的id值 必须是数据库里面的  也就是在结果集中提取的数组不是空数组 否则说明不存在此列数据 不存在此相册
//然后在photo_add_img.php?id=<?php echo $_GET['id'] 把id在传入到photo_add_img.php页面
//到了photo_add_img.php页面 提取tg_dir 作为下面上传a链接的title 以便通过js进入到upimg.php后 upimg.php能得到当前相册的tg_dir
//然后在js中 open的小窗口的链接是 upimg.php?dir='+this.title 这样进入到upimg.php后通过$_GET['dir']就能得到当前相册的tg_dir
//注意在upimg.php中 必须先将传过来的$_GET['dir']做为隐藏表单的value POST后 用$_POST['dir']作为目录 不能直接$_GET['dir']作为目录
//这样 图片就会被传入到相应的文件夹 这个文件夹dir对应创建他的id 这个id就是点击后一直传id进来到这个页面的id
//总之这几个页面  通过链接  顺序传递了tg_dir表中的id(也就是tg_photo表中的tg_sid)作为?id= 的值  从而保证相应相册存入及展示相应图片
//在photo_add_img.php页面中 将tg_dir表中的id(被传递的id)写入tg_photo表中作为了tg_sid

//执行上传图片功能
if ($_GET['action'] == 'up') {	
	//设置上传图片的类型
	$_files = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
	//判断类型是否是数组里的一种
	if (is_array($_files)) {
		if (!in_array($_FILES['userfile']['type'],$_files)) {
			_alert_back('上传图片必须是jpg,png,gif中的一种！');
		}
	}
	//判断文件错误类型
	if ($_FILES['userfile']['error'] > 0) {
		switch ($_FILES['userfile']['error']) {
			case 1: _alert_back('上传文件超过约定值1');
				break;
			case 2: _alert_back('上传文件超过约定值2');
				break;
			case 3: _alert_back('部分文件被上传');
				break;
			case 4: _alert_back('没有任何文件被上传！');
				break;
		}
		exit;
	}
	//判断配置大小
	if ($_FILES['userfile']['size'] > 1000000) {
		_alert_back('上传的文件不得超过1M');
	}
	//获取文件扩展名 做成文件名
	$_n = explode('.', $_FILES['userfile']['name']); //将xxxx.abc切成数组 那$_n[1]就是后缀名abc
	$_name = $_POST['dir'].'/'.time().'.'.$_n[1];
	//移动文件
	if (is_uploaded_file($_FILES['userfile']['tmp_name'])) { 
		//注意这里必须先将传过来的$_GET['dir']做为隐藏表单的value POST过来后 用$_POST['dir']作为目录 不能直接$_GET['dir']作为目录
		//这样 图片就会被传入到相应的文件夹 这个文件夹dir对应创建他的id 这个id就是点击后一直传id进来到这个页面的id
		if	(!@move_uploaded_file($_FILES['userfile']['tmp_name'],$_name)) {
			_alert_back('移动失败');
		} else {
			//上传成功后 找到他的父窗口id='url'的元素 给这个元素写上被上传图片的文件路径
			echo "<script>alert('上传成功！');window.opener.document.getElementById('url').value='$_name';window.close();</script>";
			exit();
		}
	} else {
		_alert_back('上传的临时文件不存在！');
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
		<input type="hidden" name="dir" value="<?php echo $_GET['dir'] ?>" />
	</form>
</div>







</body>
</html>
