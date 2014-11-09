<?php
//表单

/*
//header的用法
// header('Location:demo2.php');  //一刷新这个页面 就自动跳转到demo2.php页面
// header('Location:http://www.baidu.com'); //跳到百度的网站 记得加http
header('Content-Type:text/html; charset=utf-8'); //设置页面编码 因为文件编码已经通过IDE设置为了UTF-8所以页面编码也必须设置为UTF-8
echo '我是utf-8';
echo "<br/>";
echo "<br/>";
//header之前不能有任何的输出 比如echo print_r之类的否则会报错 在输出前加上ob_start()开启缓冲区 先缓冲了输出内容那就没关系
//在某些编辑器中 可以设置文件编码为UTF-8带BOM头 其实这也是输出了 之后用header设置编码也会报这个错误
//Cannot modify header information - headers already sent by (output started at C:\AppServ\www\phpStudy\demo\8form.php:5)
//而且这里指的输出也包括<?php之上的空格 所以<?php 之上不能有空格输出 或者在空格之上第一行加上php语句ob_start() 缓冲空格

//接收来之8form_1的表单数据 <form method="post" action="8form.php"> 
//由于get发送 会在url上显示username=xxxxx 而且还可以改动 所以一般表单提交都用post
if(isset($_POST["username"])){     
	echo "提交了<br/>";
	$username = $_POST["username"];  //获取输入框输入的内容 也就是name="username"这个input的value
	$username = trim($username);     //去掉这个内容的空格
	$username = htmlspecialchars($username);  //如果这个内容包括html标签 不解析这个标签
	if(strlen($username)<2){                  //如果这个内容字符串长度小于2位 后续这里可以用正则做筛选
		echo "用户名不能小于2位<br/>";             //在8form.php文档中输出这句提示用户
		exit;                                   //程序跳出 后续不会在8form.php文档中输出这个内容
	}
	echo '我的用户名是：'.$username."<br>";                    //在8form.php文档中输出这个内容
}else{                             //用的get方法指向的现在这个php文档 或者没有 name="username"这个input 那就是非法提交
	echo "非法提交<br/>";
}
echo "<br/>";
echo "<br/>";
echo "<br/>";
*/


//基本的表单验证  接收来自8form_2.php的表单数据 <form method="post" action="8form.php">
header('Content-Type:text/html; charset=utf-8');
//1：验证是否是8form_2.php提交过来的
if(!isset($_POST["send"])||$_POST["send"]!="提交"){  //如果不是name="send"的提交按钮提交过来的 
	//echo "不是我要的页面提交的";                        //或者这个提交按钮的value!="提交"
	header("Location:8form_2.php");  //那页面还是指向到自己的原页面form.php并不跳转到这个页面 注意header()前面不能有任何html输出 
	exit;                            //并且程序退出 
}

//2：接收所有数据 就是通过他们的name接收他们的value
$username = trim($_POST["username"]);     //过滤左右两边的空格
$password = $_POST["password"];
$email = $_POST["email"];
$code = trim($_POST["code"]);             //过滤掉左右两边的空格 便于后面的字符串长度判断
$content = htmlspecialchars($_POST["content"]);  //不解析html标签

//3：设置验证
if(strlen($username)<3||strlen($username)>10){   //如果用户名输入的字符串 小于2位大于10位
	echo "<script>alert('用户名不能小于3位，不能大于10位');history.back();</script>";  //用js弹窗 同时返回到上个页面 也就是不会进入现在这个php页面
	exit;     //程序跳出
}
if(strlen($code)!=4||!is_numeric($code)){        //如果验证码输入的字符串 不是4位 或者不是全数字
	echo "<script>alert('验证码必须是4位，必须是纯数字');history.back();</script>";
	exit;
}
if(!preg_match('/^([\w\.]{2,255})@([\w\-]{1,255}).([a-z]{2,4})$/',$email)){   //如果电子邮件格式不符合正则表达式
	echo "<script>alert('电子邮件不合法');history.back();</script>";
	exit;
}

//4：执行此php文档的相应操作
echo "用户名：".$username."<br/>";
echo "密　码：".$password."<br/>";
echo "邮　箱：".$email."<br/>";
echo "验证码：".$code."<br/>";
echo "简　介：".$content."<br/>";

?>


