<?php
if(!defined("IN_TG")){
	exit("Access Denied");
}

if(!function_exists("_alert_back")){
	exit("_alert_back()函数不存在");
}


/*
@_check_username表示检测并过滤用户名
@access public
@param string $_string 原始输入的用户名
@param int $_min_num 用户名最小位数
@param int $_max_num 用户名最大位数
@return string 过滤后的用户名
*/
function _check_username($_string,$_min_num,$_max_num){
	$_string = trim($_string);        //1:去掉两边的空格
	
	if(mb_strlen($_string,"utf-8")<$_min_num || mb_strlen($_string,"utf-8")>$_max_num){    //必须大于$_min_num位 小于$_max_num位
		_alert_back("用户名不能小于".$_min_num."位，不能大于".$_max_num."位");
	}
	
	$_char_pattern = '/[<>\'\"\ ]/';
	if(preg_match($_char_pattern,$_string)){   //2:非法字符 如果包括这些非法字符 就_alert_back();
		_alert_back("用户名不得包含非法字符");
	}

	return _mysql_string($_string);//4:返回的字符进行转义 为进入数据库准备 '之类的符号进入数据库后会被转义 不会引起数据库歧义
}


/*
@_check_password表示验证两次输入的密码并加密密码
@access public
@param string $_first_pass 输入的密码
@param string $_end_pass 再次输入的密码
@param int $_min_num 密码最小位数
@return string 加密后的密码
*/
function _check_password($_first_pass,$_min_num){
	if(strlen($_first_pass)<6 || strlen($_first_pass)>30){
		_alert_back("密码必须大于".$_min_num."位，并且小于30位");
	}

	return _mysql_string(sha1($_first_pass));   //返回的密码 是经过sha1加密过的密码
}


function _check_time($_string){
	$_time = array('0','1','2','3');
	if(!in_array($_string,$_time)){        //如果输入的用户名$_string是$_mg数组的某个元素 不可以注册
		exit("保留方式出错");
	}

	return _mysql_string($_string);
}

//生产cookie
function _setcookies($_username, $_uniqid, $_time){ 
	switch ($_time){
		case '0';   //默认不保存
			setcookie('username', $_username);
			setcookie('uniqid', $_uniqid);
			break; 
		case '1';   //一天
			setcookie('username', $_username, time()+86400);
			setcookie('uniqid', $_uniqid, time()+86400);
			break;
		case '2';   //一周
			setcookie('username', $_username, time()+604800);
			setcookie('uniqid', $_uniqid, time()+604800);
			break;
		case '3';  //一月
			setcookie('username', $_username, time()+2592000);
			setcookie('uniqid', $_uniqid, time()+2592000);
			break;
	}
}






















?>