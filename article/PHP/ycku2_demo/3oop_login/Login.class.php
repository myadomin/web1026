<?php

//登录类  继承User抽象类  
class Login extends User{
	//构造方法  接收$_POST["xx"]等传参  把接收的参数设置为父类定义好的_username等的属性值
	public function __construct($userName, $passWord){
		$this->_username = $userName;
		$this->_password = $passWord;
	}
	
	//覆写_query()方法 读取XML对比用户填写的用户名密码
	public function _query(){
		$_sxlf = simplexml_load_file("user.xml");
		//读取之前注册生成好的XML文档username标签值  这个值就是用户注册填的用户名
		$_usernameInXml = $_sxlf->username[0];	
		$_passwordInXml = $_sxlf->password[0];	
		//如果用户填写的用户名密码都等于读取XML的用户名密码  那就是登录成功  否则登录失败
		if($_usernameInXml == $this->_username && $_passwordInXml == $this->_password){
			setcookie('username', $this->_username);	//登录成功 就生成cookie 必须在index.php的html标签前ob_start()
			Tool::alertLocaton("登录成功".$this->_username, "index.php?index=member");
		}else{
			Tool::alertBack("登录失败，用户名或者密码错误");
		}
	}
	
	//覆写_check()方法  做登录验证  返回true或false
	public function _check(){
		if(empty($this->_username) || empty($this->_password)){
			return false;
		}else{
			return true;
		}
	}
}

?>