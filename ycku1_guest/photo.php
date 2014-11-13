<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//总流程
//进入photo.php 读取数据库dir 将相册目录都展示出来
//点击相册目录后  通过?id=xxx 将dir表的id值依次传到photo_show.php photo_add_img.php  
//然后在photo_add_img中通过$_GET['id']读取数据库得到得到dir 将dir通过js传到upimg.php
//根据这个dir 在upimg.php执行上传  将图片上传到这个dir图片目录   并且把路径写入到photo_add_img中
//photo_add_img提交表单  把信息都存入到数据库表photo中  跳到photo_show.php中
//在photo_show.php中读取数据库表photo 把这个图片目录的图片都展示出来

//删除相册目录  必须管理员才能删除
if($_GET['action'] == 'delete' && isset($_GET['id']) && isset($_SESSION['admin']) && isset($_COOKIE['username'])){
	//获取要删除的目录路径
	$rows_dir = mysql_fetch_array(mysql_query("SELECT dir FROM dir WHERE id='{$_GET['id']}'"));
	$dir = $rows_dir['dir'];
	
	//删除dir表对应的目录数据
	mysql_query("
			DELETE FROM dir
			WHERE id = '{$_GET['id']}'
			LIMIT 1
			") or die(mysql_error());
	if(mysql_affected_rows() == 1){
		//删除photo表对应的图片数据
		mysql_query("
				DELETE FROM photo
				WHERE sid = '{$_GET['id']}'
				") or die(mysql_error());
		//删除此目录对应的文件夹及图片文件
		if(d_rmdir($dir)){
			alert_back('删除目录成功');
		}else{
			alert_back('删除文件失败');
		}
	}else{
		alert_back('删除目录失败');
	}
}


//读取显示相册列表
//从$pagenum条数据开始  读取$pagesize条数据
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pagesize = 4;
$pagenum = ($page-1)*$pagesize;
$result = mysql_query("
		SELECT id, name, type, content, dir, face
		FROM dir
		ORDER BY date
		DESC
		LIMIT $pagenum, $pagesize
		") or die(mysql_error());

//得到所有页数总共有多少条数据  从而得到共多少页  从而决定li循环多少次
$total = mysql_num_rows(mysql_query("SELECT id FROM dir"));
$pageabsolute = ceil($total/$pagesize);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--相册列表</title>
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
	<?php 
	while (!!$rows = mysql_fetch_array($result)){
		if($rows['type']){
			$type = '私密';
		}else{
			$type = '公开';
		}	
		if(empty($rows['face'])){
			$img = '';
		}else{
			$img = '<img src="'.$rows['face'].'" alt="" />';
		}
		//统计各个相册里共有多少张图片
		$result_count = mysql_query("
			SELECT COUNT(*)
			AS count
			FROM photo
			WHERE sid = '{$rows['id']}'
		");
		$rows_count = mysql_fetch_array($result_count);
	?>
	<dl>
		<dt><a href="photo_show.php?id=<?php echo $rows['id']?>"><?php echo $img?></a></dt>
		<dd>
			<a href="photo_show.php?id=<?php echo $rows['id']?>">
				<?php echo $rows['name']?>(<?php echo $type?>)
			</a>
		</dd>
		<dd>共有<?php echo $rows_count['count']?>张图片</dd>
		<?php if(isset($_COOKIE['username']) && isset($_SESSION['admin'])){?>
		<dd>
			<a href="photo_modify_dir.php?id=<?php echo $rows['id']?>">[修改]</a> 
			<a href="?action=delete&id=<?php echo $rows['id']?>">[删除]</a>
		</dd>
		<?php }?>
	</dl>
	<?php 
	} 
	mysql_free_result($result);
	?>
	<?php if (isset($_SESSION['admin']) && isset($_COOKIE['username'])) {?>
	<p><a href="photo_add_dir.php">添加目录</a></p>
	<?php }?>
	<?php paging(1); ?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
