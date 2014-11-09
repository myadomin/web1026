<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//分页 提取结果集
//这里提取的tg_id是tg_dir的id 也就是相册目录的id
_page("SELECT tg_id FROM tg_dir", 15);  //得出所有分页需要的数据
global $_pagenum, $_pagesize;  //这里其实做不做全局都无所谓 因为_page函数里面已经做了全局 这里是认识的 只是为了IDE不警告而已
$_result = mysql_query("
		SELECT 
			tg_id, tg_name, tg_type, tg_date, tg_face
		FROM 
			tg_dir 
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
	<h2>相册列表</h2>
	<?php  //循环输出dl及内部的数据库信息 分页
	while (!!$_rows = mysql_fetch_array($_result)){
		if($_rows['tg_type'] == 0){
			$_type = '<br/>(公开相册)';
		}else{
			$_type = '<br/>(私密相册)';
		}
		if(!!$_rows['tg_face']){   //如果tg_face有设置 不是空
			$_face = '<img src="'.$_rows['tg_face'].'"/>';
		}else{
			$_face = '<div style="width:93px;height:93px;"></div>';
		}
	?>
	<dl>
		<dt><a href="photo_show.php?id=<?php echo $_rows['tg_id'] ?>"><?php echo $_face ?></a></dt>
		<dd><a href="photo_show.php?id=<?php echo $_rows['tg_id'] ?>"><?php echo $_rows['tg_name'] ?><?php echo $_type ?></a></dd>
		<?php if (isset($_SESSION['manage']) && isset($_COOKIE['username'])) {?>
		<dd><a href="photo_modify_dir.php?id=<?php echo $_rows['tg_id']?>">[修改]</a> [删除]</dd>
		<?php }?>
	</dl>
	<?php 
	}  
	mysql_free_result($_result);
	_paging(1);  //调用这个就是数字分页
	_paging(2);  //调用这个就是文字分页
	?>
	<?php if (isset($_SESSION['manage']) && isset($_COOKIE['username'])) {?>
	<p><a href="photo_add_dir.php">添加目录</a></p>    
	<?php }?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
