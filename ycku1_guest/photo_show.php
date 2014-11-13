<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_show');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';


//删除图片
if($_GET['action'] == 'delete' && isset($_GET['id'])){
	$result_del = mysql_query("
			SELECT username, url
			FROM photo
			WHERE id='{$_GET['id']}'
			LIMIT 1
			") or die(mysql_error());
	$rows_del = mysql_fetch_array($result_del);
	
	//只有图片上传者及管理员才有权删除此图片
	if($rows_del['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])){
		//开始删除数据库图片
		mysql_query("
				DELETE FROM photo
				WHERE id = '{$_GET['id']}'
				LIMIT 1
				") or die(mysql_error());
		if(mysql_affected_rows() == 1){
			//删除图片文件
			if(file_exists($rows_del['url'])){
				unlink($rows_del['url']);
				alert_back('删除图片成功');
			}else{
				alert_back('此文件不存在');
			}
		}else{
			alert_back('删除图片失败');			
		}
	}else{
		alert_back('你无权删除此图片');
	}
}


//接收photo.php传过来的id 传递id到photo_add_img.php 
if(isset($_GET['id'])){
	$result = mysql_query("
			SELECT id, type, password
			FROM dir
			WHERE id='{$_GET['id']}'
			LIMIT 1
			");
	if(!$rows = mysql_fetch_array($result)){
		alert_back('非法id');
	}
	
	//读取数据表photo 筛选sid等于id的数据展示出来  展示的图片是缩略图
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$pagesize = 8;
	$pagenum = ($page-1)*$pagesize;
	$result_photos = mysql_query("
			SELECT name, url, content, sid, username, date, id, readcount, commentcount
			FROM photo
			WHERE sid='{$_GET['id']}'
			ORDER BY date
			DESC
			LIMIT $pagenum, $pagesize
			") or die(mysql_error());
	//得到所有页数总共有多少条数据  从而得到共多少页  从而决定li循环多少次
	$total = mysql_num_rows(mysql_query("SELECT id FROM photo WHERE sid='{$_GET['id']}'"));
	$pageabsolute = ceil($total/$pagesize);
	
	//加密相册的密码验证
	if($_POST['password']){
		if($rows['password'] == sha1($_POST['password'])){
			//如果密码验证通过  就生成对应相册的cookie 一直可以访问  直到用户关闭浏览器结束对话就清空cookie
			setcookie('photo_pass'.$rows['id'], 'yes');
			//由于cookie的延时  所以不能直接往下执行  重定向一次
			alert_location(null, 'photo_show.php?id='.$rows['id']);
		}else{
			alert_back('相册密码错误');
		}
	}
}else{
	alert_back('非法操作');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--图片列表</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<?php 
	//非加密类型  或者有通过密码验证生成的cookie 或者管理员  显示图片列表
	if(($rows['type'] == 0) || isset($_COOKIE['photo_pass'.$rows['id']]) || isset($_SESSION['admin'])){
	?>
		<h2>图片展示<?php echo isset($_SESSION['admin'])?></h2>
		<?php while (!!$rows_photos = mysql_fetch_array($result_photos, MYSQL_ASSOC)) {?>
		<dl>
			<dt>
				<a href="photo_detail.php?id=<?php echo $rows_photos['id']?>">
					<img src="thumb.php?filename=<?php echo $rows_photos['url']?>&percent=0.3" />
				</a>
			</dt>
			<dd><?php echo $rows_photos['name']?></dd>
			<dd>
				阅(<strong><?php echo $rows_photos['readcount']?></strong>) 
				评(<?php echo $rows_photos['commentcount']?>) 
				上传者：<?php echo $rows_photos['username']?>
			</dd>
			<!-- 只有图片上传者或者管理员  才能删除图片 -->
			<?php if($rows_photos['username'] == $_COOKIE['username'] || isset($_SESSION['admin'])){?>
			<dd><a href="photo_show.php?action=delete&id=<?php echo $rows_photos['id']?>">[删除]</a></dd>
			<?php }?>
		</dl>
		<?php } mysql_free_result($result_photos)?>
		<?php paging(1, 'id='.$_GET['id'].'&')?>
		<p><a href="photo.php">返回相册目录</a></p>
		<!-- 接收photo.php传过来的id 传递id到photo_add_img.php  -->
		<p><a href="photo_add_img.php?id=<?php echo $rows['id']?>">上传图片</a></p>
	<?php }else{ 
		//不满足上面三个条件之一的  都显示密码输入界面  如果没登陆退回去登陆
		if(!$_COOKIE['username']){
			alert_location('请先登录', 'login.php');
		}
	?>
		<form action="?id=<?php echo $rows['id']?>" method="post">
			<p>
				请输入密码：<input type="password" name="password"/>
				<input type="submit" value="确认"/>
			</p>
		</form>
	<?php }?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
