<?php
ob_start();
header('Content-Type:text/html; charset=utf-8');
//cookie session

//cookie存在客户端 而且只能存储50个左右 不安全 但是不占用服务器资源
setcookie('name', 'luo', time()+(7*24*60*60)); //设置出一个cookie 名称是name 内容是luo 过期时间是7天后 time()代表当前的时间戳秒
// setcookie('name', 'luo', time()-1);   //删除cookie 注意setcookie语句类似header 之前不能有任何echo等输出 必须写输出前
echo $_COOKIE['name']."<br/>";  //通过超级全局变量 读取名称为name的cookie的内容 注意如果改动luo为其他 要刷新两次才能显示其他 
if(isset($_COOKIE['name'])){
	echo '名称是name的cookie是存在的';
}else{
	echo '名称是name的cookie是不存在的';
}
echo "<br/>";

//session存在服务器端比较安全 无数量限制 一般存放1440秒 会自动销毁 如果关闭了浏览器也自动销毁了
session_start();   //使用session在多个网页间传值 必须先开启这句
$_SESSION['name'] = 'luo';  //设置session
// unset($_SESSION['name']);   //销毁session
if(isset($_SESSION["name"])){
	echo $_SESSION["name"];
}else{
	echo '不存在此人';
}
session_destroy();   //最后销毁所有的session


//cookie使用与会员登录 购物车等 会员比较多 如果用session会占用太多的服务器资源
//session一般用于少量的页面间的数据传输 例如验证码 或者后台管理登录 保证安全 


?>