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
	
	$_char_pattern = '/[<>\'\"]/';
	if(preg_match($_char_pattern,$_string)){   //2:非法字符 如果包括这些非法字符 就_alert_back();
		_alert_back("用户名不得包含非法字符");
	}
	
	$_mg[0] = "aaa";                //3:敏感用户名
	$_mg[1] = "bbb";
	$_mg[2] = "ccc";
	foreach($_mg as $value){
		$_mg_string .= $value."&nbsp";    //aaa bbb ccc
	}
	if(in_array($_string,$_mg)){        //如果输入的用户名$_string是$_mg数组的某个元素 不可以注册
		exit("".$_mg_string."这些敏感用户名不得注册");
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
function _check_password($_first_pass,$_end_pass,$_min_num){
	if(strlen($_first_pass)<6 || strlen($_first_pass)>30){
		_alert_back("密码必须大于".$_min_num."位，并且小于30位");
	}
	
	if($_first_pass != $_end_pass){
		_alert_back("密码和确认密码不一致");
	}
	
	return _mysql_string(sha1($_first_pass));   //返回的密码 是经过sha1加密过的密码
}

function _check_modify_password($_string, $_min_num){
	if(!empty($_string)){
		if(strlen($_string) < $_min_num){
			_alert_back('密码不得小于'.$_min_num.'位');
		}
	}else{
		return null;
	}
	return sha1($_string);
}

/*
@_check_question表示密码问题验证
@access public
@param string $_string 输入的密码问题
@param int $_min_num 问题最小位数
@param int $_max_num 问题最大位数
@return string 准备传入数据库的字符串
*/
function _check_question($_string,$_min_num,$_max_num){
	if(mb_strlen($_string,"utf-8")<$_min_num || mb_strlen($_string,"utf-8")>$_max_num){    //必须大于$_min_num位 小于$_max_num位
		_alert_back("密码问题不能小于".$_min_num."位，不能大于".$_max_num."位");
	}
	
	return _mysql_string($_string);
}

/*
@_check_answer表示密码回答处理
@access public
@param string $_ques 输入的密码问题
@param string $_answ 输入的密码回答
@param int $_min_num 回答最小位数
@param int $_max_num 回答最大位数
@return string 加密后的密码回答
*/
function _check_answer($_ques,$_answ,$_min_num,$_max_num){
	if(mb_strlen($_answ,"utf-8")<$_min_num || mb_strlen($_answ,"utf-8")>$_max_num){    //必须大于$_min_num位 小于$_max_num位
		_alert_back("密码回答不能小于".$_min_num."位，不能大于".$_max_num."位");
	}
	
	if($_ques == $_answ){
		_alert_back("密码提示不能与密码回答一致");
	}
	
	return _mysql_string(sha1($_answ));
}

//检测邮箱
function _check_email($_string){
	$_char_pattern = '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/';
	if(!preg_match($_char_pattern,$_string)){
		_alert_back("邮件格式不正确");
	}	

	return _mysql_string($_string);	
}

//检测qq
function _check_qq($_string){
	if(empty($_string)){
		return null;
	}
	
	$_char_pattern = "/^[1-9]{1}[0-9]{4,9}$/";
	if(!preg_match($_char_pattern,$_string)){
		_alert_back("qq格式不正确");
	}
	
	return _mysql_string($_string);
}

//检测主页网址
function _check_url($_string){
	if((empty($_string))||($_string == "http://")){
		return null;
	}
	
	$_char_pattern = '/^(https?:\/\/)?([a-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
	if(!preg_match($_char_pattern,$_string)){
		_alert_back("网址不正确");
	}
	
	return _mysql_string($_string);
}

//检测唯一标示符
function _check_uniqid($_first_uniqid,$_end_uniqid){
	if($_first_uniqid != $_end_uniqid){
		_alert_back("唯一标示符异常");
	}
 	return _mysql_string($_first_uniqid);
}

function _check_content($_string, $_min_num, $_max_num){
	if(mb_strlen($_string,"utf-8")<$_min_num || mb_strlen($_string,"utf-8")>$_max_num){    //必须大于$_min_num位 小于$_max_num位
		_alert_back("内容不能小于".$_min_num."位，不能大于".$_max_num."位");
	}
	return $_string;
}

//帖子标题长度为4到40
function _check_post_title($_string){
	if(mb_strlen($_string, 'utf-8')<4 || mb_strlen($_string, 'utf-8')>40){
		_alert_back('标题不能小于4位大于40位');
	}
	return $_string;
}

//帖子内容长度大于10
function _check_post_content($_string){
	if(mb_strlen($_string, 'utf-8')<10){
		_alert_back(' 内容不能小于10位');
	}
	return $_string;
}


















?>
