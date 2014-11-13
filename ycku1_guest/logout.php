<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//$_COOKIE['username']存储用户名  跨页面调用判断是否为登录状态
//$_SESSION['code']存储验证码  $_SESSION['admin']管理员身份  跨页面调用判断是否为管理员
//这些cookie session退出后都要清空  然后跳到index.php
unset_cookie();
session_destroy();
alert_location('退出成功', 'index.php');

?>


