<?php

//拒绝PHP低版本
if(PHP_VERSION<"4.1.0"){
	exit("PHP version is too low");
}

//防止恶意调用
if(!defined("IN_TG")){
	exit("Access Denied");
}

//定义硬路径
define('ROOT_PATH', substr(dirname(__FILE__), 0, -8));

//引入全局函数文件
require ROOT_PATH.'includes/global.func.php';

//连接数据库
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '070924');
define('DB_NAME', 'myweb');
connect_db();

//获取程序刚开始运行的时间
define('START_TIME', get_now_time());

?>