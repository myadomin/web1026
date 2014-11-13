<?php
/*
 * 形成验证码图片 src="code.php"就是引入这个图片
 */

//开启session
session_start();

//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);

//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//形成验证码图片
code();

?>