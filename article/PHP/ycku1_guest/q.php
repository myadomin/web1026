<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','q');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//初始化
if (isset($_GET['num']) && isset($_GET['path'])) {
	if (!is_dir(ROOT_PATH.$_GET['path'])) {
		alert_back('非法操作');
	}
} else {
	alert_back('非法操作');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--Q图选择</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/qopener.js"></script>
</head>
<body>

<div id="q">
	<h3>选择Q图</h3>
	<dl>
		<?php for($i=1; $i<=$_GET['num']; $i++) {?>
		<dd><img src="<?php echo $_GET['path'].$i?>.gif" alt="<?php echo $_GET['path'].$i?>.gif" title="头像<?php echo $i?>" /></dd>
		<?php }?>
		
	</dl>
</div>

</body>
</html>
