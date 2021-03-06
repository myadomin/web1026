<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','post');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//登录后才能发帖
if(!$_COOKIE['username']){
	alert_location('登录才能发帖', 'login.php');
}

//帖子信息写入数据库
if($_GET['action'] == 'post'){
	//验证验证码
	check_code($_POST['code'], $_SESSION['code']);
	//60秒内不能重复发帖
	if(time() - $_COOKIE['post_time'] < SYS_POST){
		alert_back('60秒内不能重复发帖');
	}
	//引入验证函数库
	include ROOT_PATH.'includes/check.inc.php';
	//准备存入数据库的数据
	$clean = array();
	$clean['username'] = $_COOKIE['username'];
	$clean['type'] = $_POST['type'];
	$clean['title'] = check_username($_POST['title'], 2, 40);
	$clean['content'] = $_POST['content'];
	mysql_query("
		INSERT INTO article(username, type, title, content, date)
		VALUES('{$clean['username']}', '{$clean['type']}', '{$clean['title']}', '{$clean['content']}', NOW())
	") or die(mysql_error());
	if(mysql_affected_rows() == 1){
		//cookie存储发帖时间为当前时间戳
		setcookie('post_time', time());
		$clean[id] = mysql_insert_id();
		alert_location('发帖成功', 'article.php?id='.$clean[id]);
	}else{
		alert_back('发帖失败');
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--发表帖子</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/post.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="post">
	<h2>发表帖子</h2>
	<form method="post" name="post" action="?action=post">
		<dl>
			<dt>请认真填写一下内容</dt>
			<dd>
				类　　型：
				<?php 
					foreach (range(1,16) as $_num) {
						if ($_num == 1) {
							echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" checked="checked" /> ';
						} else {
							echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" /> ';
						}
						echo ' <img src="images/icon'.$_num.'.gif" alt="类型" /></label>';
						if ($_num == 8) {
							echo '<br />　　　 　　';
						}
					}
				?>
			</dd>
			<dd>标　　题：<input type="text" name="title" class="text" /> (*必填，2-40位)</dd>
			<dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a>　 <a href="javascript:;">Q图系列[2]</a>　 <a href="javascript:;">Q图系列[3]</a></dd>
			<dd>
				<div id="ubb">
					<img src="images/fontsize.gif" title="字体大小" alt="字体大小" />
					<img src="images/space.gif" title="线条" alt="线条" />
					<img src="images/bold.gif" title="粗体" />
					<img src="images/italic.gif" title="斜体" />
					<img src="images/underline.gif" title="下划线" />
					<img src="images/strikethrough.gif" title="删除线" />
					<img src="images/space.gif" />
					<img src="images/color.gif" title="颜色" />
					<img src="images/url.gif" title="超链接" />
					<img src="images/email.gif" title="邮件" />
					<img src="images/image.gif" title="图片" />
					<img src="images/swf.gif" title="flash" />
					<img src="images/movie.gif" title="影片" />
					<img src="images/space.gif" />
					<img src="images/left.gif" title="左区域" />
					<img src="images/center.gif" title="中区域" />
					<img src="images/right.gif" title="右区域" />
					<img src="images/space.gif" />
					<img src="images/increase.gif" title="扩大输入区" />
					<img src="images/decrease.gif" title="缩小输入区" />
					<img src="images/help.gif" />
				</div>
				<div id="font">
					<strong onclick="font(10)">10px</strong>
					<strong onclick="font(12)">12px</strong>
					<strong onclick="font(14)">14px</strong>
					<strong onclick="font(16)">16px</strong>
					<strong onclick="font(18)">18px</strong>
					<strong onclick="font(20)">20px</strong>
					<strong onclick="font(22)">22px</strong>
					<strong onclick="font(24)">24px</strong>
				</div>
				<div id="color">
					<strong title="黑色" style="background:#000" onclick="showcolor('#000')"></strong>
					<strong title="褐色" style="background:#930" onclick="showcolor('#930')"></strong>
					<strong title="橄榄树" style="background:#330" onclick="showcolor('#330')"></strong>
					<strong title="深绿" style="background:#030" onclick="showcolor('#030')"></strong>
					<strong title="深青" style="background:#036" onclick="showcolor('#036')"></strong>
					<strong title="深蓝" style="background:#000080" onclick="showcolor('#000080')"></strong>
					<strong title="靓蓝" style="background:#339" onclick="showcolor('#339')"></strong>
					<strong title="灰色-80%" style="background:#333" onclick="showcolor('#333')"></strong>
					<strong title="深红" style="background:#800000" onclick="showcolor('#800000')"></strong>
					<strong title="橙红" style="background:#f60" onclick="showcolor('#f60')"></strong>
					<strong title="深黄" style="background:#808000" onclick="showcolor('#000')"></strong>
					<strong title="深绿" style="background:#008000" onclick="showcolor('#808000')"></strong>
					<strong title="绿色" style="background:#008080" onclick="showcolor('#008080')"></strong>
					<strong title="蓝色" style="background:#00f" onclick="showcolor('#00f')"></strong>
					<strong title="蓝灰" style="background:#669" onclick="showcolor('#669')"></strong>
					<strong title="灰色-50%" style="background:#808080" onclick="showcolor('#808080')"></strong>
					<strong title="红色" style="background:#f00" onclick="showcolor('#f00')"></strong>
					<strong title="浅橙" style="background:#f90" onclick="showcolor('#f90')"></strong>
					<strong title="酸橙" style="background:#9c0" onclick="showcolor('#9c0')"></strong>
					<strong title="海绿" style="background:#396" onclick="showcolor('#396')"></strong>
					<strong title="水绿色" style="background:#3cc" onclick="showcolor('#3cc')"></strong>
					<strong title="浅蓝" style="background:#36f" onclick="showcolor('#36f')"></strong>
					<strong title="紫罗兰" style="background:#800080" onclick="showcolor('#800080')"></strong>
					<strong title="灰色-40%" style="background:#999" onclick="showcolor('#999')"></strong>
					<strong title="粉红" style="background:#f0f" onclick="showcolor('#f0f')"></strong>
					<strong title="金色" style="background:#fc0" onclick="showcolor('#fc0')"></strong>
					<strong title="黄色" style="background:#ff0" onclick="showcolor('#ff0')"></strong>
					<strong title="鲜绿" style="background:#0f0" onclick="showcolor('#0f0')"></strong>
					<strong title="青绿" style="background:#0ff" onclick="showcolor('#0ff')"></strong>
					<strong title="天蓝" style="background:#0cf" onclick="showcolor('#0cf')"></strong>
					<strong title="梅红" style="background:#936" onclick="showcolor('#936')"></strong>
					<strong title="灰度-20%" style="background:#c0c0c0" onclick="showcolor('#c0c0c0')"></strong>
					<strong title="玫瑰红" style="background:#f90" onclick="showcolor('#f90')"></strong>
					<strong title="茶色" style="background:#fc9" onclick="showcolor('#fc9')"></strong>
					<strong title="浅黄" style="background:#ff9" onclick="showcolor('#ff9')"></strong>
					<strong title="浅绿" style="background:#cfc" onclick="showcolor('#cfc')"></strong>
					<strong title="浅青绿" style="background:#cff" onclick="showcolor('#cff')"></strong>
					<strong title="浅蓝" style="background:#9cf" onclick="showcolor('#9cf')"></strong>
					<strong title="淡紫" style="background:#c9f" onclick="showcolor('#c9f')"></strong>
					<strong title="白色" style="background:#fff" ></strong>
					<em><input type="text" name="t" value="#" /></em>
				</div>
				<textarea name="content" rows="15"></textarea>
			</dd>
			<dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="发表帖子" /></dd>
		</dl>
	</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
