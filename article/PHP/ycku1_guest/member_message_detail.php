<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member_message_detail');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//判断是否登录了
if (!isset($_COOKIE['username'])) {
	alert_back('请先登录！');
}

//在member_message_detail.php中点击了删除后  js进行location.href='?action=delete&id='+this.name; 把id值作为删除的name value值  
//也就是删除$_GET['id']对于的那条数据
if($_GET['action'] == 'delete' && isset($_GET['id'])){
	mysql_query("
		DELETE FROM message
		WHERE id='{$_GET['id']}'
		LIMIT 1	
	") or die(mysql_error());
	if(mysql_affected_rows() == 1){
		alert_location('删除成功', 'member_message.php');
	}else{
		alert_back('删除失败');
	}
	exit();
}

//接收member_message传过来的id 从而读取对应的字段值
if(!isset($_GET['id'])){
	alert_back('非法操作');
}
$result = mysql_query("
	SELECT id, fromuser, content, date, status
	FROM message
	WHERE id='{$_GET['id']}'
	LIMIT 1
");
$rows = mysql_fetch_array($result);

//如果查看了某条短信  status状态就转为1已读
if(empty($rows['status'])){
	mysql_query("
		UPDATE message
		SET status = 1
		WHERE id = '{$_GET['id']}'
		LIMIT 1
	");
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--短信详情</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/member_message_detail.js"></script>
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
		<h2>短信详情</h2>
		<dl>
			<dd>发 信 人：<?php echo htmlspecialchars($rows['fromuser'])?></dd>
			<dd>内　　容：<strong><?php echo htmlspecialchars($rows['content'])?></strong></dd>
			<dd>发信时间：<?php echo htmlspecialchars($rows['date'])?></dd>
			<dd class="button">
				<input type="button"  value="返回列表" id="return" /> 
				<input type="button"  value="删除短信" id="delete" name="<?php echo $rows['id']?>"/>
			</dd>
		</dl>
	</div>
</div>		
<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>