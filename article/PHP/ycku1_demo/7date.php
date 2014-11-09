<?php
//时间与日期

//bool checkdate ( int $month , int $day , int $year )
if(checkdate(7,16,2010)){     //如果代表日期的这三个整型数字和合乎日期的 就返回true
	echo "合法日期";
}else{
	echo "不合法日期";
}
echo "<br/>";

echo date("Y")."\n";    //2014 年
echo date("y")."\n";    //14   年
echo date("M")."\n";    //Feb  月
echo date("m")."\n";    //02   月
echo date("D")."\n";    //Thu  星期几
echo date("d")."\n";    //13   日
echo date("H")."\n";    //6    时 H代表24小时制 但是本地当前时间是14点 他这个给的是东0区标准时间 而我们是东8区所以要加8是14点 后续有调时区函数
echo date("h")."\n";    //6    时 h代表12小时制 
echo date("i")."\n";    //20   分  
echo date("s")."\n";    //36   秒  
echo "<br/>";

echo date("Y-m-d H:i:s");     //2014-02-13 06:21:18  常用的写法 -和:在第一个参数的手册里不存在 就不会解析
echo "<br/>";
//以上的date()函数只写了第一个参数，如果不写第二个参数 那就是当前的时间
//如果写了第二个参数，那就返回第二个参数的时间，第二个参数必须是秒数型的时间戳
echo date("Y-m-d H:i:s",255122564);   //1978-01-31 19:22:44 如果是1那就是1970-01-01 00:00:01
echo "<br/>";

print_r(getdate());    					//不传参数就是当前时间
//Array ( [seconds] => 38 [minutes] => 35 [hours] => 6 [mday] => 13 [wday] => 4 [mon] => 2 [year] => 2014 [yday] => 43 [weekday] => Thursday [month] => February [0] => 1392273338 ) 
echo "<br/>";
$aa = getdate(2255266555566);   //传入秒数的时间戳 就是这个时间戳对于的时间
echo $aa["year"];   						//1982
echo "<br/>";
	
//获得当前时间戳
echo time();                    //1392273620获取当前时间戳 所有获得的时间戳都是东0区的秒数型数字 如果要转为我们的本地时间如下
echo "<br/>";
echo date("Y-m-d H:i:s",time()+(8*60*60));    //2014-02-13 14:44:14 我们是东八区 所以要在时间戳上加上8*60*60秒
echo "<br/>";
echo date("Y-m-d H:i:s",time()+(8*60*60)+(-7*24*60*60));    //2014-02-06 14:44:14 一周以前的事件 -7*24*60*60
echo "<br/>";

//获得指定日期的时间戳
echo mktime(14,1,2,12,9,2007);   //1197208862  获得2007年12月9号14点1分2秒的时间戳
echo "\n";
$sec = mktime(14,1,2,12,9,2007);
$sec1 = strtotime("2007-12-09 14:01:02");   //推荐使用这种 
echo date("Y-m-d H:i:s",$sec);   //2007-12-09 14:01:02
echo "<br/>";

//计算当前时间戳和指定日期时间戳的差值
$now = time();
$sec = mktime(14,1,2,12,9,2007);
echo $now - $sec;           //195065700 相差这么多秒
echo "\n\n\n";
echo round(($now-$sec)/60/60/24);    //相差2258天
echo "<br/>";

//通过strtotime() 获取时间戳 推荐使用
$a = strtotime("2010-7-16 15:16:15")-strtotime("2010-7-16 15:15:15");
if($a>=60){
	echo "请这位先生休息一会儿,等下再发帖";
}else{
	echo "xxxx";
}
echo "<br/>";
	
//获取当前时区 设置当前时区
echo date_default_timezone_get();  //UTC 获取的当前时区为UTC标准时区
echo "\n";
echo date("Y-m-d H:i:s");          //2014-02-13 07:18:04 标准时区的时间
echo "<br/>";        
date_default_timezone_set("Asia/Shanghai");   //设置时区为中国时区
echo date_default_timezone_get();  //Asia/Shanghai 获取的当前时区是中国时区了
echo "\n";
echo date("Y-m-d H:i:s");          //2014-02-13 15:19:30 中国时区的时间
echo "<br/>";

//同时获取时间戳和毫秒数
echo microtime();   //返回的是字符串 0.45626100 1392276399
echo "<br/>";
list($microsec,$sec) = explode(" ",microtime());   //通过空格 把字符串切成2个字符串 分别赋给变量$microsec和$sec
echo $microsec."秒<br/>";
echo $sec."秒<br/>";
echo ($sec + $microsec)."秒<br/>";   //1392276644.33秒
echo "<br/><br/>";

//计算for循环执行用的秒数
function sec(){                      //封装成函数 获取精确到毫秒的秒数
	list($a,$b) = explode(" ",microtime());
	return $a+$b;
}
$starttime = sec();
echo $starttime."<br/>";      //虽然这里的输出只能1392277255.76 但是其实没舍掉 后续相减还是能正确精确要小数点后很多位
for($i=0 ; $i<100000 ; $i++){
	//
}
$endtime = sec();
echo $endtime."<br/>";        //1392277255.79
echo $endtime - $starttime;   //0.0253958702087 这样就可以知道for循环用了这么多秒执行
echo "<br/>";
echo round(($endtime-$starttime),4);  ///0.0254 保留4位
	

?>