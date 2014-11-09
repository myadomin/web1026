<?php

//主类 控制界面载入 处理数据
class Main{
	private $_index;	//$_GET["index"]
	private $_send;		//$_GET["send"]
	
	//构造方法  接收参数$_GET["index"]
	public function __construct($_index = ''){
		$this->_index = $_index;
		//$_GET["index"]是空  或者$_GET["index"].inc.php这个文件不存在  那都引用的是start.inc.php
		if( empty($this->_index) || !(file_exists($this->_index.".inc.php")) ){
			$this->_index = "start";
		}
		//如果点击了登录  那_send属性就是登录  如果点击了注册  那_send属性就是注册
		if( isset($_POST["send"]) ){
			$this->_send = $_POST["send"];
		}
	}
	
	//总调度
	public function run(){
		//根据不同的$_GET["index"] 引用相应的inc文件
		require $this->_index.".inc.php";	
		//通过判断设置后的_send属性值  判断是注册还是登录  做相应的操作
		if( $this->_send == "注册" ){
			$this->_exec(new Reg($_POST['username'], $_POST['password'], $_POST['notpassword'], $_POST['email']));
		}else if( $this->_send == "登录" ){
			$this->_exec(new Login($_POST['username'], $_POST['password']));
		}
	}
	
	//传入不同的$_page实例化对象 执行不同的效果 多态
	private function _exec($_page){
		//在Reg或者Login等类中 执行验证功能_check()
		if($_page->_check()){
			//如果验证通过 进行_query操作
			$_page->_query();
		}else{
			Tool::alertBack("不能为空");
		}
	}
}


?>