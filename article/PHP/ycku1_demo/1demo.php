<?php
//变量 类型 运算符 语句

//echo print printf sprintf  
echo print "我在打印这句话";      //print "我在打印这句话"; 打印这句话 然后echo打印 print的返回值1(print的返回值永远是1) 所有这句话后面还有一个1
echo "<br/>";  
printf("我今天买了5件衣服");
echo "<br/>";                     //打印html的换行 记得php语句必须以分号结尾
printf("我今天买了%d件衣服",5);
echo "<br/>";
echo sprintf("我今天卖了%d件衣服",5);  //将这句话预留在内存中 前面加上echo才能打印出来
echo "<br/>";  
	
//变量的创建 $sum这个整体才代表一个变量 sum只是一个字符串（与js的区别）
$sum = 1;             //创建整形变量 意思就是$sum是一个变量 js中只要sum这类英文就是变量了 php中必须$sum才能认定这是一个变量
$total = 2.33;        //创建浮点型变量
$sum = $total;        //那sum就变成浮点型变量了 隐式类型转换
echo $sum;            //所以输出的时候 echo sum就是输出字符串sum了 必须echo $sum才是输出变量$sum的值 2.33

//变量的类型获取getType(xx) 强制类型转换setType(xx,xx)
$aa = 5;
$bb = 5.663;
$cc = true;
$dd = "i am";
echo getType($aa);   				//integer 
echo getType($bb);  		  	//double 浮点型都会输出double
echo getType($cc);   			  //boolean 
echo getType($dd);  			  //string 
setType($aa,"float");       //类型的强制转换 
echo setType($aa,"float");  //返回值是1
echo getType($aa);   				//double 
setType($bb,"string");
echo getType($bb);   				//string 
echo "<br/>";

//isset()判断某个变量是否存在 unset()销毁某个变量 empty()判断某个变量是否为空 is_string is_integer
$a = 5;
echo isset($a);             //isset($a)返回值是布尔值 如果$a变量存在就返回布尔值ture 那就是打印1
unset($a);                  //销毁变量$a
echo isset($a);             //isset($a)返回值是布尔值 上面已经销毁了$a变量 所以返回布尔值false 那打印就是空 什么也没有
echo "<br/>";
echo empty($a);             //$a变量已经被销毁了 所以判断是空成立 所以返回布尔值true 那就打印1
$c = "";
echo empty($c);             //$c变量为空 所以判断是空成立 所以返回布尔值true 那就打印1
$b = "abc";
echo is_string($b);         //$b变量是字符串 所以返回值是true 所以打印1
$d = 100;
echo is_integer($d);        //是整型 返回true 打印的是1
echo "<br/>";
	
//intval()
$e = 22.22;
echo intval($e);            //22 转换为整型
echo getType($e);           //double 类型还是浮点型
setType($e,"integer");
echo getType($e);           //integer 这才是真正转换为了整型
echo "<br/>";
	
//常量 常量全部大写 一旦定义就不许更改 前面也没有$
define("TOTAL",100);
echo TOTAL;
//echo phpinfo();    		  //打印各种常量 包括HTTP信息
echo "<br/>";
	
//表单变量 推荐第二种写法 第一种不推荐任意和变量混淆 已新建一个form.php 里面有表单 action="demo1.php"
//echo $username;           //一旦表单的<input type="text" name="username"/>这个框体里面输入了文字 点击提交后页面就会跳到demo1.php 并打印出输入的文字
echo $_POST['username'];    			//将表单 name="username"的input的value值提取出来 也就是输入到文本框的内容
$username = $_POST['username'];   //英文表单的method="post" 所以这里是$_POST 如果是get那就是$_GET
echo $username;
echo "<br/>";
echo "这个学生是：".$username;   //利用.链接字符串和变量 类似js的 +
	
//单引号和双引号的区别
$username = "wq";
echo "his name is $username";
echo "<br/>";
$username = "武器";
echo "his name is $username,他19岁了";       //只支持英文的标点符号,
echo "<br/>";
echo "他的名字叫".$username."，他19岁了";   //如果一定要用中文的，那就给变量加上字符串连接. 连接两边的字符串，类似js的+
echo "<br/>";
echo "武器的变量\n是$username";             //双引号会解析变量和转义符 或者路径里面的 \ /等
echo "<br/>";
echo '武器的变量\n是$username';             //单引号不会解析变量和转义符
echo "<br/>";
	
//运算符
$a = 5;
$b = 6;
$c = "a";
$d = $a + $b;
$e = $a + $c;
echo $d;             //11加法运算
echo "<br/>";
echo $e;             //5 记得和js不同 +只会加string内部是number 不会加string内部是string 如果这里$c="6"之类的就可以加出11
echo "<br/>";
echo $a != $b;       //返回ture 所以打印是1
echo "<br/>";
	
//三元运算符
$total = 100;
$sum = $total>100 ? "成功" : "失败";
echo $sum;
echo "<br/>";
for($i=0 ; $i<10 ; $i++){	
	if($i == 5){             		//0 1 2 3 4 我还是会执行for以外的下面的语句 因为$i=5的时候 就退出当前循环程序了
		break;	
	}
	echo $i;
	echo "<br/>";		
}
echo "我还是会执行for以外的下面的语句";
echo "<br/>";	
for($i=0 ; $i<10 ; $i++){	
	if($i == 5){          
		continue;	                //退出当次循环 继续下一次循环 0 1 2 3 4 6 7 8 9
	}
	echo $i;
	echo "<br/>";		
}
echo "<br/>";
for($i=0 ; $i<10 ; $i++){	
	if($i == 5){          
		exit;	               		 //0 1 2 3 4退出整个程序 就算for以外的下面的echo也不执行了
	}
	echo $i;
	echo "<br/>";		
}
echo "我还是会执行for以外的下面的语句";

//对PHP +及.的理解 通过.进行数字及字符串的链接 通过+如果是数字字符串例如"7"那就可以正常相加 否则不能
$a = 5;
$b = "7";
$c = "a";
echo $a + $b;             //12  加法运算时，如果字符串内部是数字7 也就是数字字符串 那就会自动转换为number 然后相加为12	
echo $a.$b;               //57  通过.进行字符串连接
echo $a + $c;             //5   字符串内部是非数字 那相加并不能和js一样字符串连接 只能为5
echo $a.$c;               //5a  字符串的连接用. 类似js的+
echo "<br/>";

//is_numeric()（是否为数字或数字型字符串）  is_int()  is_float()  rand()  mt_rand()
$d = "abc";
$e = "123";
$f = "123.321";
$g = 155;
$h = 155.0;
if(is_numeric($d)){           //is_numeric($d)返回false 因为他不是数字
	echo "是数字";
}else{
	echo "不是数字";	
}
echo is_numeric($e);          //is_numeric是判断是否为数组 或者是否为数字字符串 $e是数组字符串所以也返回true
echo is_float($f);            //$f不是浮点数字 false
echo is_int($g);              //$g是整型数字 true
echo is_float($h);            //$h是浮点数字 true
echo "<br/>";
echo rand();                  //产生随机整数
echo "<br/>";
echo rand(0,10);              //产生0-10之间的随机整数
echo "<br/>";
echo mt_rand(5,32);           //同上rand 但是都用这个 稳定性更好 速度更快
echo "<br/>";
echo getrandMax();            //32767
echo "<br/>";
echo mt_getrandMax();         //2147483647
echo "<br/>";
	
//数字或者数字字符串格式化 
$i = 123456.252;               		  //数字或者数字字符串都可以
echo number_format($i);        		  //123,456 只传一个参数 就是只要整数部分并格式化成 xx,xxx,xxx,xxx
echo "<br/>";
echo number_format($i,1);      		  //123,456.3 如果传第二个参数就是保留多少位小数 并且四舍五入 
echo "<br/>";
echo number_format($i,1,"#","*");   //123*456#3  用#替代小数点默认的. 用*替代默认的, 一般不用 这两个参数必须一起设置或者一起不设置

		
?>













