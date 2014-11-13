<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','manage_job');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//必须是管理员才能登录
is_admin();

//点击添加管理员 post数据到这里 修改会员信息数据库  必须写在读取管理员会员列表的前面
if($_GET['action'] == 'add'){
	mysql_query("
			UPDATE user
			SET level = 1
			WHERE username = '{$_POST['manage']}'
			") or die(mysql_error());
	if(mysql_affected_rows() == 1){
		alert_location('添加管理员成功', 'manage_job.php');
	}else{
		alert_back('添加管理员失败，不存在此用户');
	}
}

//开始辞职  只能自己辞职所以只能修改登录者的level 并清空session
if($_GET['action'] == 'job' && isset($_GET['id'])){
	mysql_query("
			UPDATE user
			SET level = 0
			WHERE id = '{$_GET['id']}' AND username = '{$_COOKIE['username']}'
			") or die(mysql_error());
	if(mysql_affected_rows() == 1){
		session_destroy();
		alert_location('辞职成功', 'index.php');
	}else{
		alert_back('辞职失败');
	}
}

//读取管理员会员列表  分页显示
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pagesize = SYS_BLOG;
$pagenum = ($page-1)*$pagesize;
$result = mysql_query("
		SELECT id, username, email, reg_time
		FROM user
		WHERE level = 1
		ORDER BY reg_time
		DESC
		LIMIT $pagenum, $pagesize
		") or die(mysql_error());
//得到所有页数总共有多少条数据  从而得到共多少页  从而决定li循环多少次
$total = mysql_num_rows(mysql_query("SELECT id FROM user WHERE level = 1"));
$pageabsolute = ceil($total/$pagesize);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--管理列表</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="member">
<?php 
	require ROOT_PATH.'includes/manage.inc.php';
?>
	<div id="member_main">
		<h2>会员列表中心</h2>
		<table cellspacing="1">
			<tr><th>ID号</th><th>会员名</th><th>邮件</th><th>注册时间</th><th>操作</th></tr>
			<?php while (!!$rows = mysql_fetch_array($result)) {?>
			<tr>
				<td><?php echo $rows['id']?></td>
				<td><?php echo $rows['username']?></td>
				<td><?php echo $rows['email']?></td>
				<td><?php echo $rows['reg_time']?></td>
				<?php if($_COOKIE['username'] == $rows['username']) {?>
				<td>[<a href="?action=job&id=<?php echo $rows['id']?>">辞职</a>]</td>
				<?php 
				}else{
				?>
				<td>无权操作</td>
				<?php 
				}
				?>
			</tr>
			<?php }?>
		</table>
		<form method="post" action="?action=add">
			<input type="text" name="manage" class="text" /> <input type="submit" value="添加管理员" />
		</form>
		<?php 
			mysql_free_result($result);
			paging(2);
		?>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>