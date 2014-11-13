<?php
//防止恶意调用
if(!defined("IN_TG")){
	exit("Access Denied");
}


/*
 * mysql数据库连接
 */
function connect_db(){
	//连接mysql
	$conn = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('mysql连接失败');
	//选择某个数据库
	mysql_select_db(DB_NAME) or die('这个数据库不存在');
	//选择字符集
	mysql_query('SET NAMES UTF8') or die('字符集错误');
}




?>