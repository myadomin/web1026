<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','thumb');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';


//缩略图  例如别的页面<img src="thumb.php?filename=photo/1414850598/1414898120.jpg&percent=0.3" alt="" />
//就是显示地址为photo/1414850598/1414898120.jpg 缩放为0.3的缩略图
if(isset($_GET['filename']) && isset($_GET['percent'])){
	thumb($_GET['filename'], $_GET['percent']);
}


/*
 * 缩略图
 */
function thumb($filename, $percent){
	//生成png的头文件
	header('Content-type:image/png');
	
	//通过getimagesize得到数据  下标0对应宽度 下表1对应高度  将这个两个下标值通过list复制给$width $height
	list($width, $height) = getimagesize($filename);
	$new_width = $width * $percent;
	$new_height = $height * $percent;
	
	//创建一个原图片0.3倍的新画布
	$new_image = imagecreatetruecolor($new_width, $new_height);
	
	//得到原图的后缀名
	$n = explode('.', $filename);
	//按照原图片创建一个画布  不同的后缀名有不同的创建方法
	switch ($n[1]) {
		case 'jpg' : $image = imagecreatefromjpeg($filename);
			break;
		case 'png' : $image = imagecreatefrompng($filename);
			break;
		case 'gif' : $image = imagecreatefrompng($filename);
			break;
	}
	
	//将原图采集后  复制到新画布上
	imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
	//输出png图  销毁临时资源
	imagepng($new_image);
	imagedestroy($new_image);
	imagedestroy($image);
}
?>