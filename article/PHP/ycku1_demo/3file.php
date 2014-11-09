<?php
header("Content-Type:text/html; charset=UTF-8");
//文件与目录

$path1 = 'C:\AppServ\www\phpStudy\demo\3file.php';  //绝对路径 注意 要用单引号 用双引号的话就解析里面的\
echo $path1."<br/>";              //绝对路径 C:\AppServ\www\phpStudy\demo\3file.php
echo dirname($path1)."<br/>";     //目录 C:\AppServ\www\phpStudy\demo
echo basename($path1)."<br/>"; 	  //文件名  3file.php
print_r(pathinfo($path1));	      //Array ( [dirname] => C:\AppServ\www\phpStudy\demo [basename] => 3file.php [extension] => php [3filename] => 3file ) 
echo "<br/>";

$path2 = '3file.php';        //相对路径 
echo realpath($path2);      //打印这个相对路径的绝对路径	但是前提是这个文件确实存在 如果写成../3file.php 上一层并不存在这个文件 那就会返回false 所以打印出空
echo "<br/>";

$path3 = 'C:\AppServ\www\phpStudy\demo\3file.php'; 
echo filesize($path3);  //882字节 参数绝对路径相对路径都可以
echo "<br/>";
echo round(filesize($path3)/1024);  //1KB
echo "<br/>";

echo round(disk_free_space('C:')/1024/1024/1024).'GB<BR/>'; //C盘 229GB磁盘剩余空间
echo round(disk_total_space('C:')/1024/1024/1024).'GB<BR/>'; //C盘 341GB总空间
	
echo fileatime($path1);   //1396704556 文件最后访问时间 毫秒时间戳
echo "<br/>";
echo filectime($path1);   //文件改变事件 删除之类的操作
echo "<br/>";
echo filemtime($path1);   //文件内容变化时间
echo "<br/>";

date_default_timezone_set('Asia/ShangHai');  //设置时区为中国时区 如果不设置下面输出本地时间就是伦敦标准事件
echo date('Y-m-d H:i:s');   //2014-04-05 22:10:32
echo "<br/>";
echo date('Y-m-d H:i:s', '1396704556');  //2014-04-05 21:29:16 可以传第二个参数 将事件戳改为相应的时间
echo "<br/>";

$fp1 = fopen('3file_w.txt', 'w');   //w只写模式 如果文件不存在 就自动创建这个文本 如果有这个文本而且文本有内容 那就清空原内容 写入下面的内容 返回值$fp是资源句柄
$outstring1 = "this is luo\r\nhe is a coder";  //这里必须双引号 才能解析内部的\r\n
//fwrite($fp, $outstring, 6);     //写入文本到文件 并且只要前6个字符 this i
fwrite($fp1, $outstring1, strlen($outstring1));  //写入文本到文件 并且只字符本身长度的字符  
fclose($fp1);  //最后记得关闭已打开的文件资源句柄 以避免浪费资源
//3file_put_contents('text.txt', '啊啊啊')  //最简洁的写法 上面的操作合成这一句 写入啊啊啊

$fp2 = fopen('3file_a.txt', 'a');  //a追加写入模式 刷新一次 就追加写入一次下面的字符串
$outstring2 = "this is luo\nhe is a coder\n";
fwrite($fp2, $outstring2);
fclose($fp2);

$fp3 = fopen('3file_r.txt', 'r');  //r 只读模式
echo fgetc($fp3)."\n";   //w 读出文本的一个字符 并指针下移一位 只能读英文 因为中文是2个字符
echo fgetc($fp3)."\n";   //o 指针下移一位
echo fgetc($fp3)."\n";   //s
//echo fgets($fp3);        //hizhidu 读出一行 这里指针已经到h了 所以不完整
//echo fgets($fp3, 4);     //hiz 必须先注释掉上一句 否则指针到最后了没有输出 第二个参数4带面输出指针开始 4-3个字符
//echo fgetss($fp3);       //读出一行 并且忽略掉HTML标签
//echo fread($fp3, 4);     //输出4个 而不是fgets的4-1个 
echo "<br/>";
while (!feof($fp3)){       //一直循环 直到资源句柄的指针指到最后为止
	echo fgetc($fp3);      //一个个字符读出打印  hizhidu di er hang di san hang
}
echo "<br/>";
rewind($fp3);   //经过上面的操作 指针到末尾了 让指针回到起始位置
echo fgetc($fp3)."\n"; //这样又有输出了 w
echo ftell($fp3)."\n"; //1 得出现在的指针是1
fseek($fp3, 4); //i 将指针直接直到4 
echo fgetc($fp3);
echo "<br/>";
fclose($fp3);

print_r(file('3file_r.txt')); //Array ( [0] => woshizhidu ) 以数组形式输出页面内容
$arr1 = file('3file_r.txt');
echo $arr1[2]."<br/>";                //di san hang 数组第三个元素 就是第三行
echo file_get_contents('3file_r.txt'); //以字符串方式 读出所有的内容 woshizhidu di er hang di san hang
echo "<br/>";

if (file_exists('3file.php')){
	echo "3file.php文件存在";
}else{
	echo "3file.php文件不存在";
}
echo "<br/>";
echo filesize('3file.php');  //4715B大小
//unlink('ssssdsfsdss.txt');  //删除文件ssssdsfsdss.txt
echo "<br/>";

$dir = opendir('C:\AppServ\www\phpStudy\demo');  //打开这个目录
while(!!$file = readdir($dir)){ //每次循环 就执行一次readdir($dir)读取一次当前目录下的一个文件名
	echo $file."<br/>";       //然后打印出这个文件 一直循环打印 直到当前目录下文件名全读取过了readdir($dir)执行后会返回false从而结束循环
}          //. .. .buildpath .project .settings 3file.php 3file_a.txt 3file_r.txt 3file_w.txt目录下所有的文件名
closedir($dir);  //最后关闭这个目录

print_r(scandir('C:\AppServ\www\phpStudy\demo')); //以数组形式 返回这个目录下的所有文件
//rmdir('fds/sdf/sdf/pdfd');  //删掉这个目录
//rename('a123.txt', 'b123.txt') //把a123.txt文件名改成b123.txt 这里传入目录 也可以改目录名

?>
