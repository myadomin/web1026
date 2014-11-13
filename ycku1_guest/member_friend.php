<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member_friend');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//判断是否登录了
if (!isset($_COOKIE['username'])) {
	alert_back('请先登录！');
}

//通过好友请求 因为要该百年status字段值  所以要在读取mysql SELECT之前
if($_GET['action'] == 'check' && isset($_GET['id'])){
	mysql_query("
		UPDATE friend
		SET status = 1
		WHERE id = '{$_GET['id']}'
	");
}

//从$pagenum条数据开始  读取$pagesize条数据
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pagesize = 6;
$pagenum = ($page-1)*$pagesize;
//通过cookie 查询到当前登录用户有多少短信留言
$result = mysql_query("
	SELECT touser, fromuser, content, date, id, status
	FROM friend
	WHERE touser = '{$_COOKIE['username']}'
	OR fromuser = '{$_COOKIE['username']}'
	ORDER BY date
	DESC
	LIMIT $pagenum, $pagesize
");
//得到所有页数总共有多少条数据  从而得到共多少页  从而决定li循环多少次
$total = mysql_num_rows(mysql_query("SELECT id FROM friend WHERE touser = '{$_COOKIE['username']}' OR fromuser = '{$_COOKIE['username']}'"));
$pageabsolute = ceil($total/$pagesize);

//批量删除勾选的短信  由于html post中name=ids[] 所以最终$_POST['ids']是数组
if($_GET['action'] == 'delete' && isset($_POST['ids'])){
	//将数组变换成  13,12,10这种字符串形式 
	$ids = implode(',', $_POST['ids']);
	//从数据库删除
	mysql_query("
		DELETE FROM friend
		WHERE id in({$ids})		
	");
	//影响的函数至少是一行  就说明批删除成功	
	if(mysql_affected_rows() >= 1){
		alert_location('信删除成功', 'member_friend.php');
	}else{
		alert_back('删除失败');
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--好友中心</title>
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
		require ROOT_PATH.'includes/member.inc.php';
	?>
	<div id="member_main">
		<h2>好友请求</h2>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
			<tr><th>好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
			<?php 
			while(!!$rows = mysql_fetch_array($result)){
			if($rows['touser'] == $_COOKIE['username']){
				$rows['friend'] = $rows['fromuser'];
				if(empty($rows['status'])){
					$status_html = '<a href="?action=check&id='.$rows['id'].'" style="color:red">你未验证</a>';
				}else{
					$status_html = '<span style="color:green">通过</span>';
				}
			}else{
				$rows['friend'] = $rows['touser'];
				if(empty($rows['status'])){
					$status_html = '<span style="color:blue">对方未验证</span>';
				}else{
					$status_html = '<span style="color:green">通过</span>';
				}
			}
			?>
			<tr>
				<td><?php echo htmlspecialchars($rows['friend'])?></td>
				<td title="<?php echo htmlspecialchars($rows['content']) ?>">
					<?php 
						echo mb_substr(htmlspecialchars($rows['content']), 0, 20, 'utf-8').'...';
					?>
				</td>
				<td><?php echo htmlspecialchars($rows['date'])?></td>
				<td>
					<?php 
					echo $status_html;
					?>
				</td>
				<!--  复选框必须会勾选多个  所以有多个value值  所以name必须用数组形式ids[] -->
				<td><input type="checkbox" name="ids[]" value="<?php echo $rows['id']?>"/></td>
			</tr>
			<?php 
			}
			mysql_free_result($result);
			?>
			<tr>
				<td colspan="5">
					<label for="all">全选 <input type="checkbox" name="chkall" id="all" /></label> 
					<input type="submit" value="批删除" />
				</td>
			</tr>
		</table>
		</form>
		<?php paging(1)?>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
