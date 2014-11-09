<?php
session_start();
define('IN_TG',true);
define('SCRIPT','photo_show');
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");

//删除某张图片
if($_GET['action'] == 'delete' && isset($_GET['id'])){
	$_result_delete = mysql_query("SELECT tg_url, tg_sid FROM tg_photo WHERE tg_id='{$_GET['id']}'");
	$_rows_delete = mysql_fetch_array($_result_delete);
	
	if(file_exists($_rows_delete['tg_url'])){  //通过url知道这个文件存在于文件夹中
		unlink($_rows_delete['tg_url']);       //那就删除这个文件
		//然后开始删除这个图片的数据库信息
		mysql_query("DELETE FROM tg_photo WHERE tg_id='{$_GET['id']}'");
		if (_affected_rows() == 1) {
			mysql_close();
// 			_location('图片删除成功',"index.php");
			_location('图片删除成功',"photo_show.php?id='{$_rows_delete['tg_sid']}'");
		} else {
			mysql_close();
			_location('图片删除失败','register.php');
		}	
	}else{
		_alert_back('不存在此文件');
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
					tg_id,tg_name,tg_type
				FROM
					tg_dir
				WHERE
					tg_id = '{$_GET['id']}'
				LIMIT
					1
			");
	$_rows = mysql_fetch_array($_result);  
	if(!$_rows){           //而且传过来的id值 必须是数据库里面的  也就是在结果集中提取的数组不是空数组 否则说明不存在此列数据 不存在此相册
		_alert_back('不存在此相册');
	}
	$_dirhtml = array();
	$_dirhtml['id'] = $_rows['tg_id'];
	$_dirhtml['name'] = $_rows['tg_name'];
	$_dirhtml['type'] = $_rows['tg_type'];

	//加密相册的验证密码
	if ($_POST['password']) {    //如果有name="password" post过来 说明是私密相册提交密码验证过来了
		$_result_password = mysql_query("SELECT tg_id FROM tg_dir WHERE tg_password='{$_POST['password']}'");
		$_rows_password = mysql_fetch_array($_result_password);
		//上面通过查找tg_dir表的tg_password等于post过来的密码那行的数据 如果没找到那行数据 说明密码不正确 类似验证登陆
		if(!$_rows_password){ 
			_alert_back('相册密码不正确');
		}else{ 
			 //如果密码正确 生成cookie 便于后续内容展示 每个页面有自己单独的cookie避免覆盖 所以cookie名称是'photo'.$_dirhtml['id']
			setcookie('photo'.$_dirhtml['id'],$_dirhtml['name']);
			//cookie有一定的滞后性 所以重定向到现在这个页面
			_location('密码正确','photo_show.php?id='.$_dirhtml['id']);
		}
	}
}else{
	_alert_back('非法操作');
}

$_percent = '0.3';

//分页 提取数据库数据  只提取tg_photo中 tg_sid=传过来的id那些行数据 因为进入一个相册 对应展示的是那个相册里的图片
//传过来的id在上面已经$_dirhtml['id'] = $_rows['tg_id']; 所以这里WHERE tg_sid='{$_dirhtml['id']}'
_page("SELECT tg_id FROM tg_photo WHERE tg_sid='{$_dirhtml['id']}'", 4);  //得出所有分页需要的数据
global $_pagenum, $_pagesize;  //这里其实做不做全局都无所谓 因为_page函数里面已经做了全局 这里是认识的 只是为了IDE不警告而已
$_id = 'id='.$_dirhtml['id'].'&';  //为了分页 把传过来的id作为分页?id的值
$_result = mysql_query("
		SELECT
			tg_id, tg_name, tg_url, tg_sid, tg_username, tg_readcount
		FROM
			tg_photo
		WHERE
			tg_sid='{$_dirhtml['id']}'
		ORDER BY
			tg_date DESC
		LIMIT
			$_pagenum,$_pagesize
");

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
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<h2>图片展示[<?php echo $_dirhtml['name']?>]</h2>
	<?php 
	//如果tg_dir表中的tg_type是0 说明是公开相册 才显示下面 否则就进入了下面的else
	//如果用户密码输入正确 就会在上面生成cookie 所以这里的cookie就会等于$_dirhtml['name'] 再进就不用输密码了 直到他登出 或者关闭页面清空了cookie为止
	//如果是管理员 这三个如果满足一个就可以看到下面的内容
	if(empty($_dirhtml['type']) || $_COOKIE['photo'.$_dirhtml['id']] == $_dirhtml['name'] || isset($_SESSION['manage'])){  
		//循环数据库中 tg_sid等于进入这个相册传过来的id那些行的所有数据 然后显示
		while(!!$_rows = mysql_fetch_array($_result)){
			$_filename = $_rows['tg_url'];
	?>
		<dl>
			<dt> <!--点击图片后 进入这个图片的大图 所以这里传的id是tg_photo表中的id 也就是这个图片的id 便于进入detail页面后 读取数据库图片 -->
				<a href="photo_detail.php?id=<?php echo $_rows['tg_id'] ?>">
					<!--这里图片的src指向的是网络地址  url是thumb.php 这个文件输出的就是图片 同时?后有filename和percent 便于thumb.php通过GET接收他们 -->
					<img src="thumb.php?filename=<?php echo $_filename?>&percent=<?php echo $_percent?>" />
				</a>
			</dt>
			<dd><?php echo $_rows['tg_name']?></dd>
			<dd>阅(<strong><?php echo $_rows['tg_readcount']?></strong>) 评(<strong>0</strong>) 上传者：<?php echo $_rows['tg_username']?></dd>
			<?php if($_rows['tg_username'] == $_COOKIE['username'] || $_SESSION['manage']){?>
			<dd><a href="photo_show.php?action=delete&id=<?php echo $_rows['tg_id']?>">[删除]</a></dd>
			<?php } //如果登录这是上传者 这个图片才会显示删除按钮  点击后 提交给自己 并传action和id?> 
		</dl>
		<?php 
		}
		mysql_free_result($_result);
		_paging(1);  //调用这个就是数字分页
		_paging(2);  //调用这个就是文字分页
		?>
		<p><a href="photo.php">返回相册</a></p>
		<p><a href="photo_add_img.php?id=<?php echo $_GET['id'] ?>">上传图片</a></p>
	<?php 
	}else{   //tg_type=1  私密相册 就进入到了else这里 表单密码页面 表单还是提交给当前的这个页面 所以id=$_dirhtml['id']
		echo '<form method="post" action="photo_show.php?id='.$_dirhtml['id'].'">';
		echo '<p>请输入密码：<input type="password" name="password" /> <input type="submit" value="确认" /></p>';
		echo '</form>';
	}
	?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
