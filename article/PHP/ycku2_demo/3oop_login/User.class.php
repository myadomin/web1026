<?php

//定义抽象类  作为login reg的父类  规范login reg的属性和方法
abstract class User{
	//具备的属性
	protected $_username;
	protected $_password;
	protected $_notpassword;
	protected $_email;
	
	//注册登录需要分别覆写的抽象方法  
	//点击注册生成XML 点击登录就读取XML 多态 
	abstract function _query();

	//注册登录需要分别覆写的抽象方法 多态  
	//登录验证  注册验证  多态
	abstract function _check();
}

?>