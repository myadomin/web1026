<?php
header('Content-Type:text/html; charset=utf-8');
//mysql操作

// if(mysql_connect("localhost","root","070924")){
// 	echo "数据库连接成功<br/>";
// }else{
// 	echo "数据库连接失败<br/>";
// }


/*
//1连接数据库
define('DB_HOST','localhost');    //连接上数据库
define('DB_USER','root');
define('DB_PWD','070924');
define('DB_NAME','school'); 
$conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD) or die('数据库连接失败'.mysql_error());
echo $conn;             //Resource id #2 资源句柄
echo "<br/>";

//2选定数据库 设置编码
mysql_select_db(DB_NAME,$conn) or die('选定的这个数据库不存在'.mysql_error());
mysql_query('SET NAMES utf8',$conn) or die('编码设置不成功'.mysql_error());

//3输入sql语句 得到结果
$query = "SELECT * FROM grade";
$result = mysql_query($query,$conn) or die('SQL语句输入错误'.mysql_error());
print_r(mysql_fetch_array($result,MYSQL_ASSOC)); 
//通过数组形式 得到结果 Array ( [id] => 1 [name] => 一一 [email] => ayi@163.com [point] => 99 [regdate] => 2014-02-14 16:24:21 ) 

//4释放内存 关闭数据库
mysql_free_result($result);
mysql_close($conn);
*/



//数据库的增删改查
//1初始化 连接数据库 选定数据库 设置编码
header("Content-Type:text/html,charset:utf-8");
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','070924');
define('DB_NAME','school');
$conn = @mysql_connect(DB_HOST,DB_USER,DB_PWD) or die('数据库连接失败'.mysql_error());
mysql_select_db(DB_NAME,$conn) or die('选定的这个数据库不存在'.mysql_error());
mysql_query('SET NAMES utf8',$conn) or die('编码设置不成功'.mysql_error());

//2 增 给表grade增加一行数据 
$query = "INSERT INTO grade(    
	name,
	email,
	point,
	regdate
) VALUES (
	'adomin',
	'adomin@163.com',
	101,
	NOW()
)";
mysql_query($query) or die('增错误：'.mysql_error());

//3 删 删除表grade id=3的那行  
$query = "DELETE FROM grade WHERE id=3";
mysql_query($query) or die('删错误：'.mysql_error());

//4 改 改动表grade id=1的那行 
$query = "UPDATE grade SET point=59 WHERE id=1";
@mysql_query($query) or die('改错误：'.mysql_error());

//5 查
$query = "SELECT id,name,email,point,regdate FROM grade";
$result = mysql_query($query) or die('查错误：'.mysql_error());
while(!!$row = mysql_fetch_array($result)){            //把结果以数组方式得到 一直循环到$row为空
	echo $row["id"]."---".$row["name"]."---".$row["email"]."---".$row["point"]."---".$row["regdate"];
	echo "<br/>";
}

//6 数据库其他信息
echo mysql_field_name($result,1);    //获取表字段名 也就是列名 school数据库grade表的第2列是name   
echo "<br/>";
echo mysql_num_fields($result);      //获取字段数 也及时列数   school数据库grade表有5列
echo "<br/>";
echo mysql_num_rows($result);        //获取数据条数 也就是行数   school数据库grade表有13行
echo "<br/>";
echo mysql_get_client_info()."||";	  	//取得 MySQL 客户端信息 5.0.51a
echo mysql_get_host_info()."||";        //取得 MySQL 主机信息  	 localhost via TCP/IP
echo mysql_get_proto_info()."||";       //取得 MySQL 协议信息 	 10
echo mysql_get_server_info()."||";      //取得 MySQL 服务器信息      5.0.51b-community-nt-log

//7 关闭数据库
mysql_close($conn);


?>