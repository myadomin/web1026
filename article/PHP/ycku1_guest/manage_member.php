<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','manage_member');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//必须是管理员才能登录
is_admin();

//读取会员信息  分页显示
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pagesize = SYS_BLOG;
$pagenum = ($page-1)*$pagesize;
$result = mysql_query("
		SELECT id, username, email, reg_time
		FROM user
		ORDER BY reg_time
		DESC
		LIMIT $pagenum, $pagesize
		") or die(mysql_error());
//得到所有页数总共有多少条数据  从而得到共多少页  从而决定li循环多少次
$total = mysql_num_rows(mysql_query("SELECT id FROM user"));
$pageabsolute = ceil($total/$pagesize);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--会员列表</title>
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
		<form method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>ID号</th><th>会员名</th><th>邮件</th><th>注册时间</th><th>操作</th></tr>
			<?php while (!!$rows = mysql_fetch_array($result)) {?>
			<tr>
				<td><?php echo $rows['id']?></td>
				<td><?php echo $rows['username']?></td>
				<td><?php echo $rows['email']?></td>
				<td><?php echo $rows['reg_time']?></td>
				<td>[<a href="?action=delet&id=<?php echo $rows['id']?>">删</a>] [修]</td>
			</tr>
			<?php }?>
		</table>
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