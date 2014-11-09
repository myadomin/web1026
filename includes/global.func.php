<?php

//数据库连接
function connect_db(){
	mysql_connect(DB_HOST, DB_USER, DB_PWD) or die('数据库连接失败');
	mysql_select_db(DB_NAME) or die('此数据库不存在');
	mysql_query("SET NAMES UTF8") or die('设置字符编码失败');
}

//获取当前时间
function get_now_time(){
	$_mtime = explode(" ",microtime());
	return $_mtime[1] + $_mtime[0];
}

?>