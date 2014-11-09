<?php	
	if(!defined('IN_TG')){       //如果”IN_TG“这个常量之前没定义过 就退出程序 并输出Access Denied 
		exit('Access Denied!');    //这样就只有通过index.php这一级别的文档才能调用这个文件了 因为只有index.php这一级别的文档才定义了这个常量
	}  
	if(!defined("SCRIPT")){
		exit("Script Error");
	}
	global $_system;
?>
<link rel="shortcut icon" href="favicon.ico"/>          <!-- 一定要空格 不能写成 shortcuticon-->
	<link rel="stylesheet" type="text/css" href="style/basic.css" />
	<link rel="stylesheet" type="text/css" href="style/<?php echo SCRIPT ?>.css" />
