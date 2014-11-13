<?php
/*
 * 获取当前的时间戳  秒为单位 精确到毫秒
 * exp 12121545452.2365656512秒
 */
function get_time(){
	$time_arr = explode(" ", microtime());
	$time = $time_arr[0] + $time_arr[1];
	return $time;
}


/*
 * 验证验证码
 * $str1 用户填写的验证码
 * $str2 生成的保存在session里的图片验证码
 */
function check_code($str1, $str2){
	if(strtolower($str1) != $str2){
		alert_back('验证码错误');
	}
}


/*
 * 形成验证码图片 src="code.php"就是引入这个图片
*/
function code($width=75, $height=25, $num=4){
	//创建4位的随机码  每一位是16进制的0-f
	for($i=0; $i<$num; $i++){
		$nmsg .= dechex(mt_rand(0, 15));
	}
	
	//将生成的随机码保存到SESSION 便于传递到其他的页面
	$_SESSION['code'] = $nmsg;
	
	//创建一张图像
	$img = imagecreatetruecolor($width, $height);
	
	//背景白色  边框黑色
	$white = imagecolorallocate($img, 255, 255, 255);
	imagefill($img, 0, 0, $white);
	$black = imagecolorallocate($img, 200, 200, 200);
	imagerectangle($img, 0, 0, $width-1, $height-1, $black);
	
	//随机6个线条
	for($i=0; $i<6; $i++){
		$rand_color = imagecolorallocate($img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
		imageline($img, mt_rand(1, $width-1), mt_rand(1, $height-1), mt_rand(1, $width-1), mt_rand(1, $height-1), $rand_color);
	}
	
	//随机100个*字符串(雪花)
	for($i=0; $i<100; $i++){
		$rand_color = imagecolorallocate($img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
		imagestring($img, 1, mt_rand(1, $width-5), mt_rand(1, $height-5), '*', $rand_color);
	}
	
	//输出验证码字符串
	for($i=0; $i<strlen($nmsg); $i++){
		$rand_color = imagecolorallocate($img, mt_rand(0, 150), mt_rand(0, 150), mt_rand(0, 150));
		imagestring($img, mt_rand(3, 5), $i*$width/strlen($nmsg) + mt_rand(1, 10), mt_rand(1, $height/2), $nmsg[$i], $rand_color);
	}
	
	//输出图像
	header("Content-Type:image/png");
	imagepng($img);
	
	//销毁
	imagedestroy($img);
}


/*
 * alert信息  并返回上一个页面
 */
function alert_back($info){
	echo '<script type="text/javascript">alert("'.$info.'");history.back();</script>';
	exit();
}


/*
 * alert信息  关闭当前窗口
*/
function alert_close($info){
	echo '<script type="text/javascript">alert("'.$info.'");window.close();</script>';
	exit();
}


/*
 * alert信息  跳转到指定url 如果第一个参数是NULL 那就不alert
*/
function alert_location($info, $url){
	if(empty($info)){
		header('Location:'.$url);	
	}else{
		echo '<script type="text/javascript">alert("'.$info.'");location.href="'.$url.'";</script>';
	}
	exit();
}


/*
 * 进入数据库的字符串都转义一下  例如英文单引号转义为\' 中文单引号之类的不需要转义
 */
function mysql_string($str){
	//如果没有开启自动转义就转义下
	if(!GPC){
		return mysql_real_escape_string($str);
	}
	return $str;
}


/*
 * 生成唯一标示符
 */
function get_uniqid(){
	return sha1(uniqid(rand(), true));
}


/*
 * 生成cookie 
 * uniqid是为了防止别人伪造cookie 
 * $time是cookie过期时间
 */
function set_cookie($username, $uniqid, $time){
	switch ($time){
		case '0':
			setcookie('username', $username);
			setcookie('uniqid', $uniqid);
			break;
		case '1':
			setcookie('username', $username, time()+86400);
			setcookie('uniqid', $uniqid, time()+86400);
			break;
		case '2':
			setcookie('username', $username, time()+604800);
			setcookie('uniqid', $uniqid, time()+604800);
			break;
		case '3':
			setcookie('username', $username, time()+2592000);
			setcookie('uniqid', $uniqid, time()+2592000);
			break;
	}
}


/*
 * 删除cookie
 */
function unset_cookie(){
	setcookie('username', '', time()-1);
	setcookie('uniqid', '', time()-1);
}


/*
 * 登录状态(username cookie存在的时候)无法再进入登录或者注册页面
 */
function is_login(){
	if(isset($_COOKIE['username'])){
		alert_back('登录状态无法再登录或者注册，请先退出');
	}
}


/*
 * 必须是管理员才能登录
 */
function is_admin(){
	if(!(isset($_COOKIE['username']) && isset($_SESSION['admin']))){
		alert_back('必须是管理员才能登录');
	}
}


/*
 * 分页html
 * $type 数字分页 文本分页
 */
function paging($type, $id=null){
	//将这两个变量设置为全局变量  任何include这个函数的文件  预先定义的这两个变量在这里都能被认识
	global $page, $pageabsolute, $total;
	if($type == 1){
		echo '<div id="page_num">';
		echo '<ul>';
		for($i=1; $i<$pageabsolute+1; $i++){
			if($page == $i){
				echo '<li><a href="'.SCRIPT.'.php?'.$id.'page='.$i.'" class="selected">'.$i.'</a></li>';
			}else{
				echo '<li><a href="'.SCRIPT.'.php?'.$id.'page='.$i.'">'.$i.'</a></li>';
			}
		}
		echo '</ul>';
		echo '</div>';
	}else if($type == 2){
		echo '<div id="page_text">';
		echo '<ul>';
		echo '<li>'.$page.'/'.$pageabsolute.'页</li> ';
		echo '<li>共有<strong>'.$total.'</strong>个会员</li> ';
		if ($page == 1) {
			echo '<li>首页 | </li>';
			echo '<li>上一页 | </li>';
		} else {
			echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
			echo '<li><a href="'.SCRIPT.'.php?page='.($page-1).'">上一页</a> | </li>';
		}
		if ($page == $pageabsolute) {
			echo '<li>下一页 | </li>';
			echo '<li>尾页</li>';
		} else {
			echo '<li><a href="'.SCRIPT.'.php?'.$id.'page='.($page+1).'">下一页</a> | </li>';
			echo '<li><a href="'.SCRIPT.'.php?'.$id.'page='.$pageabsolute.'">尾页</a></li>';
		}
		echo '</ul>';
		echo '</div>';
	}
}


/*
 * 形成xml文档
 * $filename xml文档名称
 * $_clean 信息组成的数组
 */
function set_xml($filename, $_clean){
	//新建文件new.xml 可写
	$fp = fopen('new.xml', 'w');
	if(!$fp){
		exit('系统错误，文件新建不成功');
	}
	
	//锁定
	flock($fp, LOCK_EX);
	
	//形成字符串
	$_string .="<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
	$_string .="<vip>\r\n";
	$_string .="\t<id>{$_clean['id']}</id>\r\n";
	$_string .="\t<username>{$_clean['username']}</username>\r\n";
	$_string .="\t<sex>{$_clean['sex']}</sex>\r\n";
	$_string .="\t<face>{$_clean['face']}</face>\r\n";
	$_string .="\t<email>{$_clean['email']}</email>\r\n";
	$_string .="\t<url>{$_clean['url']}</url>\r\n";
	$_string .="</vip>";
	
	//写入
	fwrite($fp, $_string);
	
	//解锁  关闭
	flock($fp, LOCK_UN);
	fclose($fp);
	
	//上面的 fopen fwrite flock 等同于下一句
// 	file_put_contents($filename, $_string);
}


/*
 * 解析ubb代码
 */
function ubb($_string) {
	$_string = nl2br($_string);
	$_string = preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px">\2</span>',$_string);
	$_string = preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
	$_string = preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$_string);
	$_string = preg_replace('/\[u\](.*)\[\/u\]/U','<span style="text-decoration:underline">\1</span>',$_string);
	$_string = preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through">\1</span>',$_string);
	$_string = preg_replace('/\[color=(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$_string);
	$_string = preg_replace('/\[url\](.*)\[\/url\]/U','<a href="\1" target="_blank">\1</a>',$_string);
	$_string = preg_replace('/\[email\](.*)\[\/email\]/U','<a href="mailto:\1">\1</a>',$_string);
	$_string = preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1" alt="图片" />',$_string);
	$_string = preg_replace('/\[flash\](.*)\[\/flash\]/U','<embed style="width:480px;height:400px;" src="\1" />',$_string);
	return $_string;
}


/*
 * 删除非空目录  rmdir只能删除空目录
 */
function d_rmdir($dirname) {   //删除非空目录 
	if(!is_dir($dirname)) { 
		return false; 
	} 
	$handle = @opendir($dirname); 
	while(($file = @readdir($handle)) !== false){ 
		if($file != '.' && $file != '..'){ 
			$dir = $dirname . '/' . $file; 
			is_dir($dir) ? d_rmdir($dir) : unlink($dir); 
		} 
	} 
	closedir($handle); 
	return rmdir($dirname) ; 
} 









?>