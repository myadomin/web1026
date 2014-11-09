<?php
define('IN_TG',"任意东西");
define("SCRIPT","member_message");  //与member_message共用css
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");
session_start();

if (!isset($_COOKIE['username'])) {
	_alert_back('请先登录！');
}
//必须是管理员才能登录
_manage_login();

//删除用户 <a href="?action=delete_user&id=<?php echo $_rows['tg_id'] >">删除</a> 通过这个得到要删除用户的tg_id 
if($_GET['action'] == 'delete_user'){
	//echo $_GET['id'];  //不同的用户下点击的删除 传过来这个用户的tg_id
	mysql_query("
			DELETE 
			FROM 
				tg_user 
			WHERE 
				tg_id='{$_GET['id']}'
			");
	if (_affected_rows() == 1) {
		mysql_close();
		_location('用户删除成功','manage_member.php');
	} else {
		mysql_close();
		_alert_back('用户删除失败');
	}	
}

//分页  
_page("SELECT tg_id FROM tg_user", 10);  //得出所有分页需要的数据
global $_pagenum, $_pagesize;  //这里其实做不做全局都无所谓 因为_page函数里面已经做了全局 这里是认识的 只是为了IDE不警告而已
$_result = mysql_query("
		SELECT 
			tg_id, tg_username, tg_email, tg_reg_time
		FROM 
			tg_user
		ORDER BY 
			tg_username DESC 
		LIMIT 
			$_pagenum,$_pagesize
		");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--会员列表</title>
<?php
require ROOT_PATH."includes/title.inc.php";    //把三句link都写到title.inc.php里面去
?>
<script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>
<?php 
require ROOT_PATH.'includes/header.inc.php';   //在commom.inc.php中定义了常量ROOT_PATH 在这里也用硬路径
?>

<div id="member">
	<?php 
	require ROOT_PATH.'includes/manage.inc.php';
	?>
	<div id="member_main">
		<h2>会员列表</h2>
		<form method="post" action="?action=user">
		<table border="1" cellspacing = "0">
			<tr><th>会员名</th><th>邮箱</th><th>注册时间</th><th>操作</th></tr>
			<?php while(!!$_rows = mysql_fetch_array($_result)) { ?>
				<tr>
					<td><?php echo $_rows['tg_username'] ?></td>
					<td><?php echo $_rows['tg_email'] ?></td>
					<td><?php echo $_rows['tg_reg_time'] ?></td>
					<td><a href="?action=delete_user&id=<?php echo $_rows['tg_id'] ?>">删除</a>　<a href="###">修改</a></td>
				</tr>
			<?php } ?>
		</table>
		</form>
		<?php 
		mysql_free_result($_result);
		_paging(1);  //调用这个就是数字分页
		_paging(2);  //调用这个就是文字分页
		?>
	</div>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>