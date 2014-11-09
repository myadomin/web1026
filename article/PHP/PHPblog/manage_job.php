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

//添加管理员
if($_GET['action'] == 'add'){
// 	echo $_POST['add_manage_name'];  //通过表达post发送过来的input text 里面的内容（value）
	//将上面传过来的用户名 在数据库中 将他的tg_level更新为1 他就是管理员了
	mysql_query("
			UPDATE 
				tg_user 
			SET 
				tg_level=1 
			WHERE 
				tg_username='{$_POST['add_manage_name']}'
			");
	if (_affected_rows() == 1) {
		mysql_close();
		_location('管理员添加成功！','manage_job.php');
	} else {
		mysql_close();
		_alert_back('管理员添加失败！原因：不存在此用户');
	}
}

//登录的管理员 自己辞职 就是将自己那行数据的tg_level更新为0 同时session_destroy清空$_SESSION['manage'] 这样此用户就不能进入管理页面了
if($_GET['action'] == 'quit'){
	mysql_query("
			UPDATE 
				tg_user 
			SET 
				tg_level=0 
			WHERE 
				tg_username='{$_COOKIE['username']}'
			");
	if (_affected_rows() == 1) {
		mysql_close();
		session_destroy();   //清空session
		_location('辞职成功！','index.php');
	} else {
		mysql_close();
		_alert_back('辞职失败');
	}
}

//分页  提取tg_level=1的用户列表 也就是管理员用户列表 
_page("SELECT tg_id FROM tg_user WHERE tg_level=1", 10);  //得出所有分页需要的数据
global $_pagenum, $_pagesize;  //这里其实做不做全局都无所谓 因为_page函数里面已经做了全局 这里是认识的 只是为了IDE不警告而已
$_result = mysql_query("
		SELECT 
			tg_id, tg_username, tg_email, tg_reg_time
		FROM 
			tg_user
		WHERE
			tg_level=1
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
		<table border="1" cellspacing = "0">
			<tr><th>会员名</th><th>邮箱</th><th>注册时间</th><th>操作</th></tr>
			<?php 
			while(!!$_rows = mysql_fetch_array($_result)) { 
				if($_COOKIE['username'] == $_rows['tg_username']){
					$_quit = '<a href="?action=quit">辞职</a>';
				}else{
					$_quit = '无权操作';
				}
			?>	
				<tr>
					<td><?php echo $_rows['tg_username'] ?></td>
					<td><?php echo $_rows['tg_email'] ?></td>
					<td><?php echo $_rows['tg_reg_time'] ?></td>
					<td><?php echo $_quit ?></td>
				</tr>
			<?php } ?>
		</table>
		<form method="post" action="?action=add">
			<input type="text" name="add_manage_name" value="" class="text"/>
			<input type="submit" name="add" value="添加管理员" class="submit"/>
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