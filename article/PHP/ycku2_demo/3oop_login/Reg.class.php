<?php

//注册类  继承User抽象类  
class Reg extends User{
	//构造方法  接收$_POST["xx"]等传参  把接收的参数设置为父类定义好的_username等的属性值
	public function __construct($userName, $passWord, $notPassWord, $eMail){
		$this->_username = $userName;
		$this->_password = $passWord;
		$this->_notpassword = $notPassWord;
		$this->_email = $eMail;
	}
	
	//覆写_query()方法  生成XML
	public function _query(){
		//生成$_xml字符串  _xml这四个字母的前后不能有任何空格
		$_xml = <<<_xml
<?xml version="1.0" encoding="utf-8"?>
<user>
<username>$this->_username</username>
<password>$this->_password</password>
<email>$this->_email</email>
</user>
_xml;
		//生成XML 每个标签内容值就是传入的参数$_POST[xxx]
		$_sxe = new SimpleXMLElement($_xml);
		$_sxe->asXML("user.xml");	
		//注册成功后  跳到login.inc.php
		Tool::alertLocaton("恭喜，注册成功", "index.php?index=login");
	}
	
	//覆写_check()方法  做注册验证  返回true或false
	public function _check(){
		if(empty($this->_username) || empty($this->_password) || empty($this->_notpassword) || empty($this->_email)){
			return false;
		}else{
			return true;
		}
	}
}

?>