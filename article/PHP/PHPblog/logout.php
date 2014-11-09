<?php
header("Content-type:text/html;charset=utf-8");

//下面进入common.inc.php后  如果没定义这个 他会判定不是主php调用的他  会exit("Access Denied");
define('IN_TG',"任意东西");  

//在下面的_unsetcookies();函数中最后会_session_destory(); 所以先开启session
session_start();

//引入common common移入了global 在global里写删除cookie的函数
require dirname(__FILE__).'/includes/common.inc.php';   

//在global调用此函数 删除cookie 并跳转到index.php
_unsetcookies();
?>
 


