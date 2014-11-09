<?php
define('IN_TG',"任意东西");
define("SCRIPT","member_friend");
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");
session_start();
if (!isset($_COOKIE['username'])) {
	_alert_back('请先登录！');
}

//验证好友  给等待你验证的文字加上a连接   
//一旦点击了a连接 就从新载入这个页面 然后执行下面  更新相应id的tg_state为1 然后执行到html部分 就更新了是否添加的状态了
if($_GET['action'] == 'check' && isset($_GET['id'])){
	mysql_query("UPDATE tg_friend SET tg_state=1 WHERE tg_id='{$_GET['id']}'");
	if(mysql_affected_rows() == 1){
		mysql_close();
		_location('好友验证成功', 'member_friend.php');
	}else{
		mysql_close();
		_alert_back('好友验证失败');
	}
}

//批量删除好友  记得各个checkbox表单中 name="ids[]" 这样$_post['ids']得到的才能是一个数组 包好了多选的各个id
if($_GET['action'] == 'delete' && isset($_POST['ids'])){
// 	print_r($_POST['ids']);
	$_string = _mysql_string(implode(',',$_POST['ids'])); //得到数组后 切成字符串 a,b,c
	mysql_query("DELETE FROM tg_friend WHERE tg_id IN ($_string)");
	if (_affected_rows()) {
		mysql_close();
		_location('好友删除成功','member_friend.php');
	} else {
		mysql_close();
		_alert_back('好友删除失败');
	}
}

//分页 提取当前登录用户也就是WHERE tg_touser='{$_COOKIE['username']}'的tg_fromuser, tg_content, tg_date, tg_id这些信息
_page("SELECT tg_id FROM tg_friend WHERE tg_touser='{$_COOKIE['username']}' OR tg_fromuser = '{$_COOKIE['username']}' ", 3);  //得出所有分页需要的数据
global $_pagenum, $_pagesize;  //这里其实做不做全局都无所谓 因为_page函数里面已经做了全局 这里是认识的 只是为了IDE不警告而已
$_result = mysql_query("
		SELECT 
			tg_fromuser, tg_touser, tg_content, tg_date, tg_state, tg_id
		FROM 
			tg_friend
		WHERE 
			tg_touser='{$_COOKIE['username']}' 
		OR
			tg_fromuser = '{$_COOKIE['username']}'
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
<title>多用户留言系统--好友设置</title>
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
		<h2>好友设置</h2>
		<form method="post" action="?action=delete">
		<table border="1" cellspacing = "0">
			<tr><th>好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
			<?php 	
			while(!!$_rows = mysql_fetch_array($_result)) { 
				if($_rows['tg_touser'] == $_COOKIE['username']){  //如果我是被添加好友的
					$_friend = $_rows['tg_fromuser'];             //那显示的就是添加我的人
					if(empty($_rows['tg_state'])){                //如果状态为0
						$_state = '<a href="?action=check&id='.$_rows['tg_id'].'">你未验证</a>'; //a为了验证准备                     
					}else{
						$_state = '你已验证';                        //否则我就验证了
					}
				}elseif($_rows['tg_fromuser'] == $_COOKIE['username']){ //如果我是添加好友的
					$_friend = $_rows['tg_touser'];                     //那显示的就是我要添加的人
					if(empty($_rows['tg_state'])){
						$_state = '等待对方验证';
					}else{
						$_state = '对方已验证';
					}
				}
			?>
				<tr>
					<td><?php echo $_friend ?></td>
					<td title="<?php echo $_rows['tg_content'] ?>"><?php echo _title($_rows['tg_content']) ?></td>
					<td><?php echo $_rows['tg_date'] ?></td>
					<td><?php echo $_state ?></td>
					<td><input type="checkbox" name="ids[]" value="<?php echo $_rows['tg_id']?>" /></td>
				</tr>
			<?php } ?>
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