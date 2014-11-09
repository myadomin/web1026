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
	_alert_back('非法登录！');
}
header("Content-type:text/html;charset=utf-8");


//之前做的下面的操作 是将上传的图片放入相应的目录 而在点击添加图片 submit的同时 还需要将这些图片的信息写入数据库tg_photo表
//后续进入photo_show.php的时候 再读取数据库 展示这些已写入数据库的图片
//在这里  将tg_dir表中的id(被传递的id)写入tg_photo表中作为了tg_sid
if($_GET['action'] == 'addimg'){
	include 'includes/register.func.php';
	$_clean = array();
	$_clean['name'] = $_POST['name'];   //图片名长度等php验证就不做了
	$_clean['url'] = $_POST['url'];
	$_clean['content'] = $_POST['content'];
	$_clean['sid'] = $_POST['sid'];
	mysql_query("
		INSERT INTO 
					tg_photo(
							tg_name,
							tg_url,
							tg_content,
							tg_sid,
							tg_username,
							tg_date
							)
		VALUES				
							(
							'{$_clean['name']}',
							'{$_clean['url']}',
							'{$_clean['content']}',
							'{$_clean['sid']}',
							'{$_COOKIE['username']}',
							NOW()
							)
	");
	if (_affected_rows() == 1) {
		mysql_close();
		_location('图片添加成功！','photo_show.php?id='.$_clean['sid']); //跳到进到这个页面的原页面 通过传过来的id
	} else {
		mysql_close();
		_alert_back('图片添加失败！');
	}
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
if(isset($_GET['id'])){
	$_result = mysql_query("
			SELECT
				tg_id, tg_dir
			FROM
				tg_dir
			WHERE
				tg_id = '{$_GET['id']}'
			LIMIT
				1
			");
	$_rows = mysql_fetch_array($_result);
	if(!$_rows){          
		_alert_back('不存在此相册');
	}
	$_clean = array();
	$_clean['id'] = $_rows['tg_id'];
	$_clean['dir'] = $_rows['tg_dir'];
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
		<dd>图片名称：<input type="text" name="name" class="text" /></dd>
		<dd>
			图片地址：<input type="text" name="url" id="url" readonly="readonly" class="text" /> 
			<a href="javascript:;" title="<?php echo $_clean['dir'] ?>" id="up">上传</a></dd>
		<dd>图片描述：<textarea name="content"></textarea></dd>
		<dd><input type="submit" class="submit" value="添加图片" /></dd>
	</dl>
	<input type="hidden" name="sid" value="<?php echo $_GET['id'] ?>" />
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
