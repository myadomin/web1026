<?php

//防止恶意调用
if(!defined("IN_TG")){
	exit("Access Denied");
}

//连接数据库
//将$_conn设置为全局变量 让此变量在函数外部也能被访问 
//如果外部不能访问到数据库资源句柄 那register中对数据库的操作都没有作用了
function _connect(){
	global $_conn;     
	$_conn = mysql_connect(DB_HOST,DB_USER,DB_PWD) or die("数据库连接失败");
}

//指定数据库
function _select_db(){
	mysql_select_db(DB_NAME) or die("指定的数据库不存在");
}

//设置数据库的字符集
function _set_names(){
	mysql_query("SET NAMES UTF8") or die("字符集设置错误");
}

//写入字符到数据库
function _query($_sql){
	return mysql_query($_sql);
}

function _fetch_array($_sql){
	return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
}

function _fetch_array_list($_result){
	return mysql_fetch_array($_result, MYSQL_ASSOC);
}

//如果注册成功 那就会在数据库表中 新增加一行 所以可以用如下函数判断是否注册成功
function _affected_rows(){
	return mysql_affected_rows();
}

?>