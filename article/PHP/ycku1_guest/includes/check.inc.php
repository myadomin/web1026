<?php
/*
 * 函数库  用于验证的各个字段值
 */

if(!defined("IN_TG")){
	exit('Access denied');
}


/*
 * 用户名不满足要求就alert_back
 */
function check_username($string, $min=2, $max=20){
	//去掉左右空格
	$string = trim($string);
	
	//长度小于2位或者大于20位(中文位数 所以用mb_strlen) alert_back
	if(mb_strlen($string, 'utf-8')<$min || mb_strlen($string, 'utf-8')>$max){
		alert_back("长度是".$min."到".$max."位");
	}
	
	//不能包含特殊符号
	$pattern = '/[\'\"\ <>]/';
	if(preg_match($pattern, $string)){
		alert_back('不能包含特殊符号');
	}
	
	//不能包含敏感用户名 吧xx|xxx|xxxx这样的字符串通过|形成数组
	$tmp = explode("|", SYS_STRING);
	foreach($tmp as $i){
		$mg .= $i.' ';
	}
	if(in_array($string, $tmp)){
		alert_back('不能是'.$mg.'这些敏感字符');
	}
	
	//最终注册用户名是要放入数据库的 防止sql注入 所以要sql转义
	return mysql_string($string);
}


/*
 * 用户名密码 不满足要求就alert_back
 * $str1 填写的密码
 * $str2 填写的确认密码
 */
function check_password($str1, $str2, $min=6){
	$str1 = trim($str1);
	
	//位数
	if(strlen($str1) < $min){
		alert_back('密码不得小于'.$min.'位');
	}
	
	//不能包含特殊符号
	$pattern = '/[\'\"\ \　<>]/';
	if(preg_match($pattern, $str1)){
		alert_back('密码不能包含特殊符号');
	}
	
	//密码和密码确认必须一致
	if($str1 != $str2){
		alert_back('密码和确认密码不一致');
	}
	
	//最终返回的是sha1加密的
	return sha1($str1);
}


/*
* 修改密码时候的密码验证
* $str1 修改的密码
* 为空就返回null 并且是不sha1的null
*/
function check_modify_password($str1, $min=6){
	$str1 = trim($str1);
	
	if(!empty($str1)){
		//位数
		if(strlen($str1) < $min){
			alert_back('密码不得小于'.$min.'位');
		}
	
		//不能包含特殊符号
		$pattern = '/[\'\"\ \　<>]/';
		if(preg_match($pattern, $str1)){
			alert_back('密码不能包含特殊符号');
		}
	}else{
		return null;
	}
	
	//最终返回的是sha1加密的
	return sha1($str1);
}


/*
 * 密码提示
 */
function check_passt($str1, $min=2, $max=20){
	$str1 = trim($str1);
	
	//位数
	if(mb_strlen($str1, 'utf-8')<$min || mb_strlen($str1, 'utf-8')>$max){
		alert_back("密码提示长度是".$min."到".$max."位");
	}
	
	//最终注册用户名是要放入数据库的 防止sql注入 所以要sql转义
	return mysql_string($str1);
}


/*
 * 密码回答
 * $str1 密码回答
 * $str2 密码提示
*/
function check_passd($str1, $str2, $min=2, $max=20){
	$str1 = trim($str1);

	//位数
	if(mb_strlen($str1, 'utf-8')<$min || mb_strlen($str1, 'utf-8')>$max){
		alert_back("密码回答长度是".$min."到".$max."位");
	}
	
	if($str1 == $str2){
		alert_back('密码提示与密码回答不得相同');
	}
	
	//密码回答加密
	return sha1($str1);
}


/*
 * 邮箱验证  选填
 */
function check_email($str){
	$str = trim($str);
	
	//如果填写了邮箱 就做验证
	if(!empty($str)){
		$pattern = '/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/';
		if(!preg_match($pattern, $str)){
			alert_back('邮箱格式不正确');
		}
	}
	
	return mysql_string($str);
}


/*
 * qq验证  选填
*/
function check_qq($_string) {
	if (empty($_string)) {
		return null;
	} else {
		if (!preg_match('/^[1-9]{1}[\d]{4,12}$/',$_string)) {
			alert_back('QQ号码不正确！');
		}
	}

	return mysql_string($_string);
}


/*
 * 网址验证  选填
*/
function check_url($_string) {
	if (empty($_string) || ($_string == 'http://')) {
		return null;
	} else {
		if (!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_string)) {
			alert_back('网址不正确！');
		}
	}

	return mysql_string($_string);
}


/*
 * 唯一标示符验证  post过来的唯一标示符必须是本机生成的唯一标示符  防止伪装post表单
 * $str1 post过来的唯一标示符
 * $str2 本机生成并存入到session的唯一标示符
 */
function check_uniqid($str1, $str2){
	if($str1 != $str2){
		alert_back('唯一标示符不一致');
	}
	return $str1;
}


/*
 * content必须是10到200位
*/
function check_content($string, $min=10, $max=200){
	//去掉左右空格
	$string = trim($string);

	//长度小于10位或者大于200位(中文位数 所以用mb_strlen) alert_back
	if(mb_strlen($string, 'utf-8')<$min || mb_strlen($string, 'utf-8')>$max){
		alert_back("内容长度是".$min."到".$max."位");
	}

	//最终注册用户名是要放入数据库的 防止sql注入 所以要sql转义
	return mysql_string($string);
}


/*
 * 不能为空
 */
function check_no_empty($string){
	if(empty($string)){
		alert_back('不能为空');
	}
	return mysql_string($string);
}





?>