<?php
define('IN_TG',"任意东西");
define("SCRIPT","member_message_detail");
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");
session_start();
//删除短信模块 删除完了 后面的模块就没必要加载了 所以exit()
if (!isset($_COOKIE['username'])) {
	_alert_back('请先登录！');
}
if($_GET['action'] == 'delete' && isset($_GET['id'])){
	$_result = mysql_query("SELECT tg_id FROM tg_message WHERE tg_id='{$_GET['id']}'");
	$_rows = mysql_fetch_array($_result);
	if(!$_rows){     
		_alert_back('此短信不存在');
	}
	//开始删除单条
	mysql_query("DELETE FROM tg_message WHERE tg_id='{$_GET['id']}'");
	if (_affected_rows() == 1) {
		mysql_close();
		_location('短信删除成功','member_message.php');
	} else {
		mysql_close();
		_alert_back('短信删除失败');
	} 
	exit();
}

//memeber_message.php某条信息被点击后 通过?id=xx进入这个页面 这个页面通过$_GET['id']知道要读取数据库哪一行的信息 读取完后显示在页面
if(isset($_GET['id'])){
	$_result = mysql_query("SELECT tg_fromuser, tg_content, tg_date, tg_id FROM tg_message WHERE tg_id='{$_GET['id']}'");
	$_rows = mysql_fetch_array($_result);
// 	print_r($_rows);
	if(!$_rows){
		_alert_back('此短信不存在！');
	}
}else{
	_alert_back('非法操作');
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>多用户留言系统--短信详情</title>
<?php
require ROOT_PATH."includes/title.inc.php";    //把三句link都写到title.inc.php里面去
?>
<script type="text/javascript" src="js/member_message_detail.js"></script>
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
		<h2>短信详情</h2>
		<dl>
			<dd>发 信 人：<?php echo $_rows['tg_fromuser'] ?></dd>
			<dd>内　　容：<strong><?php echo $_rows['tg_content'] ?></strong></dd>
			<dd>发信时间：<?php echo $_rows['tg_date'] ?></dd>
			<dd class="button">
				<input type="button" value="返回列表" id="back" /> 
				<input type="button" value="删除短信" id="delete" name="<?php echo $_rows['tg_id'] ?>" />
			</dd>
		</dl>
	</div>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
