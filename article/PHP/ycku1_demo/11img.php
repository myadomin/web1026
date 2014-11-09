<?php
//第一部分：创建一个图片 png jpg ------------------------------------------------
//1：设置文件的MIME类型，将输出类型改成图像流
header('Content-Type:image/png;');
//header('Content-Type:image/jpeg;');   //如果要输出jpg就在这步和第五步改动为jpeg即可

//2:创建一个图像区域，背景默认是黑色的，还没有进行颜色填充，返回的是资源句柄，以后都是操作这个资源句柄
$im = imagecreatetruecolor(200,200);     //两个参数对应宽度高度 这个时候其实就可以在第五步输出了

//3：设置一个颜色，用这个颜色填充这个图像区域
$blue = imagecolorallocate($im,0,102,255);     //第一个参数是为哪个图像区域分配专用颜色 后面三个RGB
imagefill($im,0,0,$blue);                      //从$im图像区域的坐标0 0开始填充上面的$blue色 （好像这个坐标没作用，无论写上面都全填充）

//4：在蓝色的图片上输入一些线条或者文字
$white = imagecolorallocate($im,255,255,255);  //为此图像区域设置专有颜色 白色
imageline($im,0,0,200,200,$white);             //给$im划线 从0 0开始到200 200 用白色
imageline($im,200,0,0,200,$white);             //给$im划线 从200 0开始到0 200 用白色
imagestring($im,5,70,20,"Mr.Right",$white);    //给$im写文字 用5号字体 从80 20开始 写上Mr.Right 用白色

//5：输出最终图像
imagepng($im);
//imagejpeg($im);

//6：将过程中其他的临时资源清空
imagedestroy($im);

//7:在1demo.php中以html输出此图像 在1demo.php中写上
//echo '&ltimg src="11img.php" alt="生成的图片" title="生成的图片"/>';




//第二部分：简单的4位随机验证码 ------------------------------------------------------- 
for($i=0 ; $i&lt4 ; $i++){             		//形成4位的 0到F随机数
	$nmsg .= dechex(mt_rand(0,15));		//mt_rand(0,15)产生0到15的随机数 dechex()转换为16进制0到F的随机数
}                                    		//$nmsg = $nmsg.dechex(mt_rand(0,15)); 循环4次 形成4位的0到F随机数
//echo $nmsg;

header("Content-Type:image/png");
$im = imagecreatetruecolor(60,25);   		//创建一个60 25大小的png图片

$blue = imagecolorallocate($im,0,102,255);   	//设置专有颜色蓝色 填充图片区域
imagefill($im,0,0,$blue);

$white = imagecolorallocate($im,255,255,255); 
imagestring($im,5,15,5,$nmsg,$white);        //在此图片上写上4位的随机数 用白色

imagepng($im);                               //输出图片
imagedestroy($im);                           //清空其他资源




//第三部分：导入已有的图片 加上水印 ----------------------------------------------
define("__DIR__",dirname(__FILE__)."\\");    		//__DIR__这个常量就是 C:\AppServ\www\phpStudy\ 	
header("Content-Type:image/jpeg"); 
$im = imagecreatefromjpeg(__DIR__."img/mm1.jpg");   	//获取一个jpg的图片 相对路径也可以 用绝对路径速度更快

$blue = imagecolorallocate($im,0,102,255);  
//imagestring($im,5,50,80,"hi girl",$blue);   		//给图片写上一句话 默认字体 只能英文
 	
$font = "C:/Windows/Fonts/simfang.ttf";       		//采用windows下的字体 这个字体必须是支持中文的
$text = iconv("utf-8","utf-8","你好，美女");     	
imagettftext($im,15,55,40,100,$blue,$font,$text);  	//15s代表字体大小 55代表旋转角度 40 100为坐标 

imagejpeg($im);
imagedestroy($im);




//第四部分：创建微缩图 --------------------------------------------------------------
define("__DIR__",dirname(__FILE__)."\\");
header("Content-Type:image/jpeg");

//print_r(getimagesize(__DIR__."img\mm1.jpg"));
//Array ( [0] => 400 [1] => 340 [2] => 2 [3] => width="400" height="340" [bits] => 8 [channels] => 3 [mime] => image/jpeg )
list($width, $height) = getimagesize(__DIR__."img/mm1.jpg");   	//获取原图的宽度高度
$_width = $width*0.4;                                         	//设置新图的宽度高度
$_height = $height*0.4;                                       	//以后只需要调0.4大小就行了 而且图片整体大小也会变 真正的缩放

$_im = imagecreatetruecolor($_width,$_height);                	//创建新图
$im = imagecreatefromjpeg(__DIR__."img/mm1.jpg");             	//获取原图
	
imagecopyresampled($_im,$im,0,0,0,0,$_width,$_height,$width,$height);   //新图覆盖原图
	
$blue = imagecolorallocate($im,0,102,255);  
$font = "C:/Windows/Fonts/simfang.ttf";       		//采用windows下的字体 这个字体必须是支持中文的
$text = iconv("gbk","utf-8","你好，美女");    		//将输入的中文字符串从默认的utf-8的编码改为gbk编码 以便输出中文
imagettftext($_im,14,0,60,130,$blue,$font,$text);  	//20代表字体大小 55代表旋转角度 40 150为坐标 

imagejpeg($_im,null,100);              //第二个参数为null，第三个参数为jpg特有的清晰度设置 默认75 越大越清晰文件也越大
imagedestroy($_im);
imagedestroy($im);

?>