<?php
header("Content-Type:text/html; charset=UTF-8");
//字符串

//trim()
$str = "              PHP               ";
echo $str;    		//虽然在web上好像没有空格 但是查看源代码是有空格的 一旦这个字符串文件发送 空格也会发送
echo "<br/>";
echo trim($str);  //经过trim以后 查看源文件就两边都没有空格了
echo "<br/>";

//nl2br()  
$str1 = "this is a man \n this is a women";  //经过\n的转义 在源文件是换行了 可是web上没换行 不建议用<br/>因为有些操作会过滤掉html标签
echo $str1;
echo "<br/>";
echo nl2br($str1);   //这样 既能源文件换行 又能网页换行
echo "<br/>";

$str2 = "<strong>我的</strong>";
echo $str2."\n";            //粗体的 我的
echo htmlentities($str2);   //将字符串全部转换为html文本 <strong>我的</strong>
echo "<br/>";
echo strip_tags($str2);     //去掉所有html标签 正常的 我的
echo "<br/>";

$str3 = 'this is "luo",\n he is a coder';   //这里是单引号 所以不会解析里面的转义\n
echo $str3;                      //this is "luo",\n he is a coder   
echo "<br/>";     
$datastr = addslashes($str3);		 //为了保证放入数据库的特殊符号不出现问题在所有的特殊符号前再加一个\
echo $datastr;                   //this is \"luo\",\\n he is a coder
echo "<br/>";
$outstr = stripslashes($datastr);  //如果从数据库拿出 那就再转换为原来的样子
echo $outstr;                      //this is "luo",\n he is a coder
echo "<br/>";

echo strtoupper("abc")."\n";    //改成大写 ABC
echo strtolower("ABC")."\n";    //改成小写 abc
echo "<br/>";

$str4 = "luo";
echo str_pad($str4,10,"#");    //luo#######  用#好填充到10个字节 如果不写"#"这个参数 那默认就是空格填充
echo "\n";
echo str_pad($str4,10,"*",STR_PAD_LEFT);  // *******luo 第四个参数 STR_PAD_LEFT STR_PAD_RIGHT STR_PAD_BOTH	左边填充右边填充两边均匀填充
echo "<br/>";

$email = explode("@","adomin@163.com");  //用@将字符串切割成多段 形成一个数组 每段是数组的一个元素
print_r($email);   //Array ( [0] => adomin [1] => 163.com ) 
echo "<br/>"; 

$attr = array("adomin","163.com"); 
$email2 = join("@",$attr);  //将数组合并为字符串
echo $email2;               //adomin@163.com
echo "<br/>";

$str5 = "i will#back*home";
$tok = strtok($str5," #*");
while($tok){
	echo $tok."<br/>";
	$tok = strtok(" #*");   //利用循环 能切掉所有的 空格# *这些符号
}

$str6 = "i am a man";
echo substr($str6,3,3);   //m a  从第三个字符取3个字符 如果不写第三个参数 就是从第三个字符一直取到最后
echo "<br/>";
print_r(str_split($str6));  //Array ( [0] => i [1] => [2] => a [3] => m [4] => [5] => a [6] => [7] => m [8] => a [9] => n ) 
echo "<br/>";
echo strrev($str6);         //反转字符串 nam a ma i
echo "<br/>";

echo strcmp("a","b");    	  //-1 如果是"c","b"那就是1  如果是"b","b"那就是0 不区分大小写
echo "\n";
echo strcmp("2","10");    	//1  说明"2"大于"10" 这个不是按自然比较的
echo "\n";
echo strnatcmp("2","10");   //-1 说明"2"小于"10" 这个是按自然比较的
echo "\n";
echo strlen($str6);         //10 字符串长度是10
echo "<br/>";

echo strstr("adomin@163.com","@");   //@163.com 输出@及之后的所有字符串
echo "\n";
echo strpos("adominadomin","d");     //1 查找d第一次出现的位置
echo "\n";
echo strrpos("adominadomin","d");    //7 查找d最后一次出现的位置
echo "<br/>";
echo str_replace("lee","luo","my name is lee");   //my name is luo 把lee替换成luo
echo "<br/>";
echo substr_replace("adomin","##",0,5);   //##n 从第0个位置开始拿出去5个字符串 然后用##填充这5个字符串
echo "<br/>";

$someman = "我是一个人，是不是";
echo mb_strlen($someman,"UTF-8");             //9 取中文字符长度 所有对中文字符串的操作方法都是mb_ 后面要加上中文编码格式 "GBK"
echo "<br/>";
echo mb_substr($someman,1,2,"UTF-8");         //是一
echo "<br/>";
echo mb_strpos($someman,"是",0,"UTF-8");      //1 第一次出现是第一个位置 一定要加第三个参数0
echo "<br/>";
echo mb_strrpos($someman,"是",0,"UTF-8");     //8 最后一次出现是第八个位置
echo "<br/>";

?>