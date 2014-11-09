<?php
define('IN_TG',"任意东西");
define("SCRIPT","member_friend");
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");
session_start();
if (!isset($_COOKIE['username'])) {
	_alert_back('请先登录！');
}

//批量删除花朵  记得各个checkbox表单中 name="ids[]" 这样$_post['ids']得到的才能是一个数组 包好了多选的各个id
if($_GET['action'] == 'delete' && isset($_POST['ids'])){
// 	print_r($_POST['ids']);
	$_string = _mysql_string(implode(',',$_POST['ids'])); //得到数组后 切成字符串 a,b,c
	mysql_query("DELETE FROM tg_flower WHERE tg_id IN ($_string)"); //删除那些id对应的那些行数据库数据
	if (_affected_rows()) {
		mysql_close();
		_location('花朵删除成功','member_flower.php');
	} else {
		mysql_close();
		_alert_back('花朵删除失败');
	}
}

//分页 提取当前登录用户信息
_page("SELECT tg_id FROM tg_flower WHERE tg_touser='{$_COOKIE['username']}'", 3);  //得出所有分页需要的数据
global $_pagenum, $_pagesize;  //这里其实做不做全局都无所谓 因为_page函数里面已经做了全局 这里是认识的 只是为了IDE不警告而已
$_result = mysql_query("
		SELECT 
			tg_touser, tg_fromuser, tg_content, tg_date, tg_flower, tg_id
		FROM 
			tg_flower
		WHERE 
			tg_touser='{$_COOKIE['username']}' 
		ORDER BY 
			tg_date 
		DESC LIMIT 
			$_pagenum,$_pagesize
	");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--查询花朵</title>
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
	require ROOT_PATH.'includes/member.inc.php';
	?>
	<div id="member_main">
		<h2>查询花朵</h2>
		<form method="post" action="?action=delete">
		<table border="1" cellspacing = "0">
			<tr><th>送花人</th><th>花朵数目</th><th>感言</th><th>时间</th><th>操作</th></tr>
			<?php 	
			while(!!$_rows = mysql_fetch_array($_result)) { 
				$_flower_total += $_rows['tg_flower'];
			?>
				<tr>
					<td><?php echo $_rows['tg_fromuser'] ?></td>
					<td><?php echo $_rows['tg_flower'] ?>朵<img src="images/1/x4.gif"></img></td>
					<td title="<?php echo $_rows['tg_content'] ?>"><?php echo _title($_rows['tg_content']) ?></td>
					<td><?php echo $_rows['tg_date'] ?></td>
					<td><input type="checkbox" name="ids[]" value="<?php echo $_rows['tg_id']?>" /></td>
				</tr>
			<?php } ?>
			<tr>
				<td colspan="5">共<?php echo $_flower_total ?>朵花</td>
			</tr>
			<tr>
				<td colspan="5">
					<label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label> 
					<input type="submit" value="批删除" />
				</td>
			</tr>
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