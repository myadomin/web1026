<?php 
//定义常量IN_TG 便于调用inc文件
define("IN_TG", true);

//定义需要引入的专有css js
define("SCRIPT", "face");

//引入公共文件 dirname(__FILE__)是当前文件所在的硬路径
require dirname(__FILE__)."/includes/common.inc.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>title</title>
<?php include ROOT_PATH.'includes/title.inc.php'; ?>
<script type="text/javascript" src="js/face.js"></script>
</head>
<body>

<div id="face">
	<h3>选择头像</h3>
	<dl>
		<?php for($i=1; $i<10; $i++){ ?>
		<dd><img src="face/m0<?php echo $i ?>.gif" alt="face/m0<?php echo $i ?>.gif"></img></dd>
		<?php } ?>
		<?php  for($i=10; $i<64; $i++){ ?>
		<dd><img src="face/m<?php echo $i ?>.gif" alt="face/m<?php echo $i ?>.gif"></img></dd>
		<?php } ?>
	</dl>
</div>

</body> 
</html>