<?php

//防止恶意调用
if(!defined("IN_TG")){
	exit("Access Denied");
}

//转换硬路径常量
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

//拒绝PHP低版本
if(PHP_VERSION<"4.1.0"){
	exit("PHP version is too low");
}

//引入函数库
require ROOT_PATH."includes/global.func.php";
require ROOT_PATH."includes/mysql.func.php";

//得到文件开始执行时的毫秒数
define("START_TIME",_runtime());

//定义一个常量 判定是否开启了自动转义
define("GPC",get_magic_quotes_gpc());

//数据库连接
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PWD","070924");
define("DB_NAME","phpblog");
_connect();
_select_db();
_set_names();

//读取系统表 由于common.inc.php被所有的主页面都应用了 所以所有主页面都可以得到这个提取出的数组$_system
//然后把这个数组下的各个元素 放入相应页面的位置 例如将$_system['article']替换index下的分页数8 就可以动态调节分页每页显示几条帖子了
//只做了$_system['article'] $_system['blog'] 其他没设置
if (!!$_rows = _fetch_array("
			SELECT
				tg_webname,
				tg_article,
				tg_blog,
				tg_photo,
				tg_skin,
				tg_string,
				tg_post,
				tg_re,
				tg_code,
				tg_register
			FROM
				tg_system
 			WHERE
				tg_id=1
	 		LIMIT
				1"
)) 
{
	$_system = array();
	$_system['webname'] = $_rows['tg_webname'];
	$_system['article'] = $_rows['tg_article'];
	$_system['blog'] = $_rows['tg_blog'];
	$_system['photo'] = $_rows['tg_photo'];
	$_system['skin'] = $_rows['tg_skin'];
	$_system['string'] = $_rows['tg_string'];
	$_system['post'] = $_rows['tg_post'];
	$_system['re'] = $_rows['tg_re'];
	$_system['code'] = $_rows['tg_code'];
	$_system['register'] = $_rows['tg_register'];
}else {
	_alert_back('系统表读取错误！请联系管理员检查！');
}
//设置系统变量
 


























	
	
	
?>