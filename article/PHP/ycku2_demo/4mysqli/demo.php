<?php
header("Content-type:text/html; charset=utf-8");

//mysqli操作


//1：抓取数据库所有行的信息 并遍历
/* //创建数据库连接
$_mysqli = new mysqli("localhost", "root", "070924", "guest");

//查看数据库是否连接成功  为什么用函数而不是用面向对象去捕捉数据库连接时的错误呢  因为连接错误后 $_mysqli对象就创建不成功 对象下面的方法也不能使用
if(mysqli_connect_errno()){		////如果没错误 那mysqli_connect_errno就是0 有错误 就是某个数字
	echo "数据库连接出现错误，错误信息是：".mysqli_connect_error();
	exit();
}

//捕捉数据库操作过程中出现的错误 这里可以用面向对象 因为对象已创建成功
if($_mysqli->errno){
	echo "数据库操作错误，错误的信息是：".$_mysqli->error;
}

//设置编码 便于后续从数据库输出中文的时候 编码不会错
$_mysqli->set_charset("utf8");

//执行SQL语句，把结果集赋给$_result
$_result = $_mysqli->query("SELECT * FROM g_users");

//得到结果集后，查询此表中的一行数据 每次fetch一次 指针下移一行
// print_r($_result->fetch_row());   	//索引数组形式（数字下标） 第一行
// print_r($_result->fetch_assoc()); 	//关联数组形式（键下标）   第二行
// print_r($_result->fetch_array()); 	//数组形式（数字及键下标） 第三行
// print_r($_result->fetch_object());  //对象形式

//遍历所有行数据的G_UserName的值
$_row_assoc = $_result->fetch_assoc();  		//关联数组形式（键下标） 第一行(上面已注释，指针还是在第一行)
echo $_row_assoc["G_UserName"]."<br/>"; 		//得到数组后 得到G_UserName键下面的值
while(!!$_row_assoc = $_result->fetch_assoc()){	//从第二行开始 遍历所有的G_UserName的值 判断一次就执行一次 指针下移一行
	echo $_row_assoc["G_UserName"]."<br/>";   	//每次循环 打印当前行的$_assoc数组的G_UserName下标的值
}

//面向对象形式 遍历所有行的G_UserName的值
// $_row_object = $_result->fetch_object();
// echo $_row_object->G_UserName."<br/>";
// while($_row_object = $_result->fetch_object()){
// 	echo $_row_object->G_UserName."<br/>";
// }

//销毁结果集
$_result->free();  //销毁结果集

//断开连接数据库
$_mysqli->close(); */



//2：结果集$_result的一些属性和方法
/* $_mysqli = new mysqli("localhost", "root", "070924", "guest");
if(mysqli_connect_errno()){
	echo "数据库连接错误，错误的信息是：".mysqli_connect_error();
	exit();
}
if($_mysqli->errno){
	echo "数据库操作错误，错误的信息是：".$_mysqli->error;
}
$_mysqli->set_charset("utf8");

//选取20行到30行 整个g_users表只有23行数据 所有实际有数据的只有3行
$_result = $_mysqli->query("SELECT G_UserName,G_PassWord,G_PassT,G_PassD,G_Sex FROM g_users limit 20,30");
echo $_result->num_rows."||";		//获取结果集中有多少行的数据 3行 g_users这个表的20到30行只有3行数据
echo $_result->field_count."<br/>";	//得出结果集中选取了多少字段 也就是有多少列 这里有13个字段 但是只选取了5个字段 所以是5

//获取某一个字段对象 这里指针没有变化过 所以应该这个字段对象是G_UserName（因为query语句只选了5个字段）
$_field_object = $_result->fetch_field();
print_r($_field_object);					//得到G_UserName这个字段对象后 他是一个数组形式的对象 他也有自己的属性和属性值
echo "<br/>".$_field_object->name."<br/>";	//得到这个字段对象的名称属性的属性值
while(!!$_field_object = $_result->fetch_field()){	//循环执行一次 指针下移一个字段 
	echo $_field_object->name."<br/>";		//G_UserName G_PassWord G_PassT G_PassD G_Sex
}

//一次性得到所有的字段对象 这些字段对象组成一个数组
$_field_array = $_result->fetch_fields();
print_r($_field_array);
echo "<br/>".$_field_array[0]->name."<br/>";  //G_UserName

//移动数据指针 改变当前数据行
$_result->data_seek(2);     		//改变数据指针 如果是0就是指向第20行 如果是2就指向22行了
$_row_row = $_result->fetch_row();
echo $_row_row[0]."<br/>";          //获取了第22行后 这行的第0列 就是数据表中的G_UserName字段列

//移动字段指针 改变当前字段
$_result->field_seek(2);         	//获取第三列 也就是G_PassT字段(根据query语句中选好的字段)
$_field_object = $_result->fetch_field();
echo $_field_object->name."<br/>";

$_result->free();  //销毁结果集
$_mysqli -> close();  //断开连接数据库  */



//3：多条sql语句的执行方法
/* $_mysqli = new mysqli("localhost", "root", "070924", "guest");
if(mysqli_connect_errno()){
	echo "数据库连接错误，错误的信息是：".mysqli_connect_error();
	exit();
}
if($_mysqli->errno){
	echo "数据库操作错误，错误的信息是：".$_mysqli->error;
}
$_mysqli->set_charset("utf8");

//创建三个选择数据的sql语句 使用多条sql语句同时执行的方法
$_sql = "SELECT * FROM g_users;";
$_sql .= "SELECT * FROM g_article;";
$_sql .= "SELECT * FROM g_flower";
if($_mysqli->multi_query($_sql)){  			//只会判断第一行 如果第一行sql语句有误就为false 其他都为true
	
	$_result = $_mysqli->store_result();  	//得到当前指针指向(第一行sql执行后)的结果集
	print_r($_result->fetch_row());       	//打印这个结果集(g_users表)的第一行的数据
	echo "<br/>";

	$_mysqli->next_result();    			//将指针下移一个  
	$_result = $_mysqli->store_result();	//得到当前指针指向(第二行sql执行后)的结果集
	if(!$_result){              			//如果第二条的g_article不存在 那就结果集为空 就输出错误
		echo "第二条SQL语句有误";
		exit();
	}
	print_r($_result->fetch_row());
	echo "<br/>";
	
	$_mysqli->next_result();    			//将指针再下移一个  
	$_result = $_mysqli->store_result();	//得到当前指针指向(第三行sql执行后)的结果集
	if(!$_result){              			//如果第三条的g_flower不存在 那就结果集为空 就输出错误
		echo "第三条SQL语句有误";
		exit();
	}
	print_r($_result->fetch_row());

}else{
	echo "第一条SQL语句有误";
}

$_result->free();  //销毁结果集
$_mysqli -> close();  //断开连接数据库 */



//4：执行数据库事务回滚
/* $_mysqli = new mysqli("localhost", "root", "070924", "guest");
if(mysqli_connect_errno()){
	echo "数据库连接错误，错误的信息是：".mysqli_connect_error();
	exit();
}
if($_mysqli->errno){
	echo "数据库操作错误，错误的信息是：".$_mysqli->error;
}
$_mysqli->set_charset("utf8");

//为什么需要事务回滚？
//创建两个SQL语句（起始设置G_FromUser G_Degree的值都为100进行测试）
//$_sql = "UPDATE g_flower SET G_FromUser=G_FromUser-10 WHERE G_ID=1;";
//$_sql .= "UPDATE g_friend SET G_Degree=G_Degree+10 WHERE G_ID=1";
//$_mysqli->multi_query($_sql);
//g_flower表的G_ID=1行的G_FromUser字段减去10 第二句相应字段加上10 执行一次加减一次（类似银行取钱的过程）
//如果第一句写错了 那下面的语句就不会执行(multi_query()方法特性) 那G_FromUser就不会减去10 第二句的G_Degree也不会加10 没问题
//但是如果第二句写错了 G_FromUser减去10 第二句的G_Degree却不加10 那就出问题了 两者间付出不等于得到了
//这个时候就需要事务回滚处理了 如果第二句错误 那第一句虽然执行了 也回滚撤销第一句的操作

//事务回滚操作
$_mysqli->autocommit(false);	//关闭自动提交(我要手工提交)
$_sql = "UPDATE g_flower SET G_FromUser=G_FromUser-10 WHERE G_ID=1;";
$_sql .= "UPDATE g_friend SET G_Degree=G_Degree+10 WHERE G_ID=1";
if($_mysqli->multi_query($_sql)){
	//获取第一条语句执行后影响的行数，来判断第一句是否成功变化了一行
	$_success1 = $_mysqli->affected_rows ==1 ? true : false;
	//下移一个指针 看第二条语句执行后影响的行数 看第二句是否成功变化了一行
	$_mysqli->next_result();
	$_success2 = $_mysqli->affected_rows ==1 ? true : false;
	//如果两条语句都成功的执行了
	if($_success1 && $_success2){
		//执行手工提交 两个字段相应的加减10
		$_mysqli->commit();
		echo "完美提交，两句都成功执行，两个字段相应的加减10";
	}else{
		//如果有某一句没成功执行 执行回滚 取消之前的所有操作
		$_mysqli->rollback();
		echo "某句没成功执行，执行回滚，取消之前的所有操作";
	}
}else{
	echo "第一条SQL语句有误";
	exit();
}
$_mysqli->autocommit(true);		//手工提交完了再变回到自动提交
$_mysqli -> close();  			//断开连接数据库 */



?>