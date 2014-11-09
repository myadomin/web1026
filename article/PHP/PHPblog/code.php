<?php 
	define('IN_TG',"任意东西");  //定义一个常量 这句一定要写在下面判断之前
	
	if(!defined('IN_TG')){       //如果”IN_TG“这个常量之前没定义过 就退出程序 并输出Access Denied 
		exit('Access Denied!');    //这样就只有通过index.php这一级别的文档才能调用xxx.inc.php等文件了 因为只有index.php这一级别的文档才定义了这个常量
	}                            //在header.inc.php里写也写上这个判断 但是不定义常量 这样就无法通过 ../../includes/header.inc.php路径直接访问他们了
	
	require dirname(__FILE__).'/includes/common.inc.php';  //调用coomon.inc.php文件 他里面调用了global.func.php 这里封装了_code()函数
	
	session_start();            //开启SESSION 才能使用$_SESSION["code"] = $_nmsg;
	
	_code();                   //调用_code函数 默认参数
	//_code(120,60,6,true);    //调用_code函数 设置参数            
?> 
