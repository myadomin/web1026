<?php
//防止恶意调用
if(!defined("IN_TG")){
	exit("Access Denied");
}

//返回当前的毫秒数
function _runtime(){
	$_mtime = explode(" ",microtime());
	return $_mtime[1] + $_mtime[0];
}	 

/*
_code()是验证码函数
@access public
@param int $_width表示验证码图片的长度
@param int $_height表示验证码图片的高度
@param int $_num表示验证码的位数
@param int $_flag表示验证码图片是否需要图片
@return void没有返回值
思路：通过code.php输出图片文档流 从而形成图片 
在register.php中插入图片src="code.php"
在face.js中通过点击后 this.src = this.src = "code.php?tm="+Math.random(); 形成点击后刷新code.php页面并且变化src 从而刷新验证码
*/
function _code($_width=75,$_height=30,$num=4,$flag=false){   //如果不输入参数 默认参数就是这些
	for($i=0 ; $i<$num ; $i++){
		$_nmsg .= dechex(mt_rand(0,15));
	}
	$_SESSION["code"] = $_nmsg;   //4位验证码 通过全局的$_SESSION["code"]在所有PHP文件间传递
	
	$_img = imagecreatetruecolor($_width,$_height);  //创建一个图层
	$_white = imagecolorallocate($_img,255,255,255); //创建图层专用白色
	$_black = imagecolorallocate($_img,0,0,0);       //创建图层专用黑色
	
	imagefill($_img,0,0,$_white);                    //将白色填充到图层
	
	if($flag == true){
		imagerectangle($_img,0,0,$_width-1,$_height-1,$_black);  //将黑色作为图层边框
	}
	
	for($i=0 ; $i<6 ;$i++){                          //随机颜色线条6个 并且线条的起始结束位置也随机
		$_rand_color = imagecolorallocate($_img,mt_rand(100,255),mt_rand(100,255),mt_rand(100,255));
		imageline($_img,mt_rand(1,$_width-1),mt_rand(1,$_height-1),mt_rand(1,$_width-1),mt_rand(1,$_height-1),$_rand_color);
	}
	
	for($i=0 ; $i<100 ; $i++){                      //随机颜色雪花100个 并且位置随机
		$_rand_color = imagecolorallocate($_img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
		imagestring($_img,1,mt_rand(1,$_width-1),mt_rand(1,$_height-1),"*",$_rand_color);
	}
	
	for($i=0 ; $i<strlen($_SESSION["code"]) ; $i++){   //随机每一位的验证码 $_SESSION["code"][$i]
		$_rand_color = imagecolorallocate($_img,mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
		imagestring($_img,5,$_width*$i/$num+mt_rand(1,10),mt_rand(1,$_height/2),$_SESSION["code"][$i],$_rand_color);
	}
	
	header("Content-Type:image/png");                //头文件设置 设定这个文档的输出流是图片，注意header()此函数前不能有任何的echo等输出
	imagepng($_img);                                 //输出图像
	imagedestroy($_img);
}

function _alert_back($_info){  //注意这里最外围必须用双引号 内部用单引号 不需要变量的字符串连接 如果是数组元素 元素外加大括号
	echo "<script type='text/javascript'>alert('$_info');history.back()</script>";
	exit();
}

function _alert_close($_info){
	echo "<script type='text/javascript'>alert('$_info');window.close()</script>";
	exit();
}

//验证表单输入的验证码是否正确
function _check_code($_input_code,$_img_code){   //输入的验证码是否等于生产图片的验证码
	if(strtolower($_input_code) != $_img_code){  //输入验证码都转成小写 从而不区分大小写
		_alert_back("验证码不正确");   //如果验证码不正确 跳回到原页面
		exit();             //同时程序不往下执行 也就是注册信息不写入数据库
	}
}

//为进入数据库的数据进行转义
function _mysql_string($_string){   //get_magic_quotes_gpc()在某些PHP版本开启 某些没开启
	if(!GPC){            //已在common.inc.php中define("GPC",get_magic_quotes_gpc()); 如果没有开启自动转义
		return mysql_real_escape_string($_string);   //就手动转义
	}
	return $_string;
}

//产生随机的唯一标示符
function _sha1_uniqid(){
	return _mysql_string(sha1(uniqid(rand(),true)));
}

//
function _location($_info,$_url){  //注意这里最外围必须用双引号 内部用单引号 不需要变量的字符串连接 如果是数组元素 元素外加大括号
	echo "<script type='text/javascript'>alert('$_info');location.href = '$_url' </script>";
}

//清除session
function _session_destory(){
	session_destroy();
}

//删除cookie
function _unsetcookies(){
	setcookie('username', '', time()-1);  //删除名称是username uniqid的cookie
	setcookie('uniqid', '', time()-1);
	_session_destory();
	_location('退出成功', 'index.php');
}

//登录状态下 如果有人直接通过register.php或者login.php进入登录或注册页面 不能进入
function _login_status(){
	if(isset($_COOKIE['username'])){
		_alert_back('已登录状态下不能进入此页面');
	}
}

//分页的各项数据提取的函数
function _page($_sql, $_size){
	global $_pageTotal, $_page, $_rowsTotal, $_pagesize, $_pagenum;
	//这里前三个做成全局是因为要让下面的函数能得到这三个变量 后两个设置为全局是为了blog.php的mysql_query能得到这两个变量
	//得到数据库总共有多少条数据 从而知道一共有多少页 知道一共多少页后 就知道下面要循环多少次li 显示多少个页数了
	// $_resultTotal = mysql_query("SELECT tg_id FROM tg_user"); //tg_id必定存在 他有多少个 就说明有多少行数据 或者用*
	// echo mysql_num_rows($_resultTotal);  //用下面封装好的函数 一次做完这两句的事情
	$_rowsTotal = mysql_num_rows(_query($_sql)); //得到总共有多少条数据
	$_pageTotal = ceil($_rowsTotal/$_size);     //数据总条数 除以10 再向上取证 就是总页数
	$_page = $_GET['page'];   	  //每次点击1 2 3 4等分页的数字连接 就会发送url=blog.php?page=1  这里通过get方式得到了页数
	if($_page == ''){             //刚刷新进入这个页面的时候 还没点击分页的数字 没有GET url 所以是$_page是空
		$_page = 1;               //如果是空 就显示第一页
	}
	$_pagesize = $_size;          //每页显示数据库的$_size行数据
	$_pagenum = ($_page-1)*$_size;    //从第X行开始显示
}

//封装分页函数
function _paging($_type){
	global $_pageTotal, $_page, $_rowsTotal, $_id;  
	//这里这三个做成全局是下面的语句会在blog.php中echo 为了让blog.php也能识别这个函数里的这三个变量
	//$_SERVER["SCRIPT_NAME"]就是当前页的url这里就是blog.php
	if($_type ==1){
		echo '<div id="page_num">';
		echo '<ul>';
		for($i=0; $i<$_pageTotal; $i++){
			if($_page == $i+1){   //如果生成当前页的li的时候 就给他加上class 其他页不加class
				echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.($i+1).'" class="active">'.($i+1).'</a></li>';
			}else{
				echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
			}
		}
		echo '</ul>';
		echo '</div>';
	}else if($_type ==2){
		echo '<div id="page_text">';
		echo '<ul>';
		echo '<li>'.$_page.'/'.$_pageTotal.'页 | </li>';
		echo '<li>共有<strong>'.$_rowsTotal.'</strong>个  | </li>';
		if($_page == 1){  //如果是第一页
			echo '<li>首页 | </li>';
			echo '<li>上一页 | </li>';
		}else{  //$_SERVER["SCRIPT_NAME"]就是当前文件的路径 /phpstudy/PHPblog/blog.php 这样这些语句移到其他页面也可以重用了
			echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'">首页 | </a></li>';
			echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.($_page-1).'">上一页 | </a></li>';
		}
		if($_page == $_pageTotal){  //如果是最后一页
			echo '<li>下一页 | </li>';
			echo '<li>尾页 | </li>';
		}else{
			echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.($_page+1).'">下一页 | </a></li>';
			echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?'.$_id.'page='.$_pageTotal.'">尾页 | </a></li>';
		}
		echo '</ul>';
		echo '</div>';
	}
}

//html转义
function _html($_string){
	return htmlspecialchars($_string);
}

//销毁结果集
function _free_result($_result){
	mysql_free_result($_result);
}

//多个字符 只显示14个字符
function _title($_string){
	if(mb_strlen($_string,'utf-8')>14){
		$_string = mb_substr($_string, 1, 14, 'utf-8');
	}
	return $_string;
}

//解析ubb代码
function _ubb($_string) {
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

//限时发帖
function _timed($_now_time, $_prev_time, $_second){
	if($_now_time - $_prev_time < $_second){     //当前发帖的时间  间隔上一次成功发帖的时间  要大于$_second秒
		_alert_back('请休息'.$_second.'秒后再发帖');
	}
}

//必须管理员才能进入
function _manage_login(){
	if(!isset($_COOKIE['username']) || !isset($_SESSION['manage'])){
		_alert_back('非法登录');
	}
}



?>
