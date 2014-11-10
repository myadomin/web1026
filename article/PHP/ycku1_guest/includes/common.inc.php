<?php
//utf-8编码
header("Content-type:text/html;charset=utf-8");

//防止恶意调用
if(!defined("IN_TG")){
	exit("Access Denied");
}

//定义当前项目根目录的硬路径
define("ROOT_PATH", substr(dirname(__FILE__), 0, -8));

//判断是否开启了mysql转义
define("GPC", get_magic_quotes_gpc());

//拒绝低版本
if(PHP_VERSION<"5.2.0"){
	exit("version is to low");
}

//引入全局函数库  引入数据库函数库
include ROOT_PATH."includes/global.func.php";
include ROOT_PATH.'includes/mysql.func.php';

//得到程序开始时的时间戳(精确到毫秒) 定义为常量的话  其他被include的文件也能识别
define("START_TIME", get_time());

//mysql连接
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
define("DB_PASS", '070924');
define("DB_NAME", 'ycku1_guest');
connect_db();

//读取系统表字段值
$result = mysql_query("
		SELECT webname, article, blog, photo, skin, string, post, re, code, register
		FROM system
		LIMIT 1
		") or die(mysql_error());
$rows = mysql_fetch_array($result, MYSQL_ASSOC);
$system = array();
$system['webname'] = htmlspecialchars($rows['webname']);
$system['string'] = htmlspecialchars($rows['string']);
$system['article'] = htmlspecialchars($rows['article']);
$system['blog'] = htmlspecialchars($rows['blog']);
$system['photo'] = htmlspecialchars($rows['photo']);
$system['skin'] = htmlspecialchars($rows['skin']);
$system['post'] = htmlspecialchars($rows['post']);
$system['re'] = htmlspecialchars($rows['re']);
$system['code'] = htmlspecialchars($rows['code']);
$system['register'] = htmlspecialchars($rows['register']);

//如果定义了皮肤cookie 就替换系统设置的皮肤
if($_COOKIE['skin']){
	$system['skin'] = $_COOKIE['skin'];
}

//定义系统配置项常量  
//普通变量 ：只能在当前文件才能被识别
//全局变量 ：文件间被include 文件都声明global $xx 才能都识别$xx
//常量 ：文件间被include 就能跨文件识别
//cookie session 数据库 ：第三方存储  任何文件都能读取识别  
define("WEBNAME", $system['webname']);
define("SYS_ARTICLE", $system['article']);
define("SYS_BLOG", $system['blog']);
define("SYS_POHOT", $system['photo']);
define("SYS_SKIN", $system['skin']);
define("SYS_POST", $system['post']);
define("SYS_RE", $system['re']);
define("SYS_CODE", $system['code']);
define("SYS_REGISTER", $system['register']);
define("SYS_STRING", $system['string']);












?>