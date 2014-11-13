<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','article');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';


//在本页回复的帖子 相关内容存入数据库  回复的帖子reid是对应这页主题帖子的id
//这个必须写前面  因为后面的是读取这个回帖
if($_GET['action'] == 'rearticle'){
	//验证验证码
	check_code($_POST['code'], $_SESSION['code']);
	
	//60秒内不能重复回帖
	if(time() - $_COOKIE['rearticle_time'] < SYS_RE){
		alert_back('15秒内不能重复回帖');
	}
	
	//将post过来的回帖数据存入数据库
	mysql_query("
			INSERT INTO article(reid, username, title, type, content, date)
			VALUES ('{$_POST['reid']}', '{$_COOKIE['username']}', '{$_POST['title']}', '{$_POST['type']}', '{$_POST['content']}', NOW())
			") or die(mysql_error());
	if(mysql_affected_rows() != 1){
		alert_back('回帖失败');
	}	
	
	//回帖成功  增加一次回帖数  跳转
	mysql_query("
			UPDATE article 
			SET commentcount = commentcount + 1
			WHERE id='{$_GET['id']}';
			") or die(mysql_error());
	setcookie('rearticle_time', time());
	alert_location('回帖成功', 'article.php?id='.$_GET['id']);
}


//设置精华
if($_GET['action'] == 'nice_on' && isset($_GET['id'])){
	mysql_query("
		UPDATE article
		SET nice = 1
		WHERE id = '{$_GET['id']}'
	") or die(mysql_error());
}


//取消精华
if($_GET['action'] == 'nice_off' && isset($_GET['id'])){
	mysql_query("
		UPDATE article
		SET nice = 0
		WHERE id = '{$_GET['id']}'
	");
}


//post.php发表的帖子  带上了$_GET[id] 根据id取得读取数据库相关信息  都是主题帖所以reid都是0 首页显示及这里的主题帖显示都是WHERE reid=0
//同时显示reid不为0的回帖的信息  从数据库读取  根据reid=帖子id $_GET[id]
if(isset($_GET[id])){
	//读取主题帖子信息(reid=0) 根据帖子id
	$result = mysql_query("
				SELECT username, type, title, content, readcount, commentcount, date, id, nice
				FROM article
				WHERE id = '{$_GET['id']}'
				AND reid=0
				LIMIT 1
			");
	if(!$rows = mysql_fetch_array($result)){
		alert_back('没有这个帖子');
	}
	
	//读取发表主题的用户信息 根据上面得到的用户名
	$result_user = mysql_query("
				SELECT sex, face, id, email, url, switch, autograph
				FROM user
				WHERE username = '{$rows['username']}'
				LIMIT 1
			") or die(mysql_error());
	if(!$rows_user = mysql_fetch_array($result_user)){
		alert_back('不存在此用户');
	}
	
	//个性签名
	if ($rows_user['switch'] == 1) {
		$rows_user['autograph_html'] = '<p class="autograph">'.ubb($rows_user['autograph']).'</p>';
	}
	
	//进入一次 就是累计了一次阅读量
	mysql_query("
				UPDATE article
				SET readcount = readcount+1
				WHERE id = '{$_GET['id']}'
			");
	
	//读取显示回帖  根据reid=帖子id $_GET[id]
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$pagesize = SYS_ARTICLE;
	$pagenum = ($page-1)*$pagesize;
	$result_rearticle = mysql_query("
			SELECT type, title, content, date, username
			FROM article
			WHERE reid = '{$_GET[id]}'
			ORDER BY date
			ASC
			LIMIT $pagenum, $pagesize
			") or die(mysql_error());
	//得到所有页数总共有多少条数据  从而得到共多少页  从而决定li循环多少次
	$total = mysql_num_rows(mysql_query("SELECT id FROM article WHERE reid = '{$_GET[id]}'"));
	$pageabsolute = ceil($total/$pagesize);
	
	//如果主题帖发帖人和当前用户是同一个人  就可以修改这个主题帖
	if($rows['username'] == $_COOKIE['username']){
		$subject_modify = '[<a href="article_modify.php?id='.$_GET[id].'">修改</a>]';
	}
	 
}




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--帖子详情</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>

<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>
<div id="article">
	<h2>帖子详情</h2>
	<?php if($rows['nice']) {?>
	<img src="images/nice.gif" alt="" class="nice" />
	<?php }?>
	<?php if($rows['readcount'] > 200 && $rows['commentcount'] > 10) {?>
	<!-- 浏览量大于200并且评论量大于20就是热帖 -->
	<img src="images/hot.gif" alt="" class="hot" />
	<?php }?>
	<!--  主题部分   只在第一页显示 -->
	<?php if($_GET['page'] == 1 || empty($_GET['page'])) {?>
	<div id="subject">
		<dl>
			<dd class="user"><?php echo $rows['username']?>(<?php echo $rows_user['sex']?>)(楼主)</dd>
			<dt><img src="<?php echo $rows_user['face']?>" alt="炎日" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $rows_user['id']?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $rows_user['id']?>">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $rows_user['id']?>">给他送花</a></dd>
			<dd class="email">邮件：<a href="mailto:<?php echo $rows_user['email']?>"><?php echo $rows_user['email']?></a></dd>
			<dd class="url">网址：<a href="<?php echo $rows_user['url']?>" target="_blank"><?php echo $rows_user['url']?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span>
					<?php 
					if(isset($_SESSION['admin'])) {
						if(!$rows['nice']) {
					?>
						<a href="?action=nice_on&id=<?php echo $rows['id']?>">[设置精华]</a>
						<?php }else{?>
						<a href="?action=nice_off&id=<?php echo $rows['id']?>">[取消精华]</a>
					<?php 
						}
					}	
					?>
					<?php echo $subject_modify?> 
					1#
				</span>
				<?php echo $rows['username']?> | 
				发表于：<?php echo $rows['date']?>
			</div>
			<h3>主题：<?php echo $rows['title']?> <img src="images/icon<?php echo $rows['type']?>.gif" alt="icon" /></h3>
			<div class="detail">
				<?php echo ubb($rows['content'])?>
				<?php echo $rows_user['autograph_html']?>
			</div>
			<div class="read">
				阅读量：(<?php echo $rows['readcount']?>) 评论量：(<?php echo $rows['commentcount']?>)
			</div>
		</div>
	</div>
	<p class="line"></p>
	<?php } ?>
	
	<!--  回帖部分    -->
	<?php 
	$i = 2;
	while(!!$rows_rearticle = mysql_fetch_array($result_rearticle)) {
		//根据回帖人的username 读取回帖用户信息 
		$result_reuser = mysql_query("
				SELECT sex, face, id, email, url, switch, autograph
				FROM user
				WHERE username = '{$rows_rearticle['username']}'
				LIMIT 1
				") or die(mysql_error());
		if(!$rows_reuser = mysql_fetch_array($result_reuser)){
			alert_back('不存在此用户');
		}
		if($i == 2 && $page == 1){
			if($rows_rearticle['username'] == $rows['username']){
				$is_shafa = '(楼主)';
			}else{
				$is_shafa = '(沙发)';
			}
		}else{
			$is_shafa = '';
		}
		//个性签名
		if ($rows_reuser['switch'] == 1) {
			$rows_reuser['autograph_html'] = '<p class="autograph">'.ubb($rows_reuser['autograph']).'</p>';
		}
	?>
	<div class="re">
		<dl>
			<dd class="user"><?php echo $rows_rearticle['username']?>(<?php echo $rows_reuser['sex']?>)<?php echo $is_shafa?></dd>
			<dt><img src="<?php echo $rows_reuser['face']?>" alt="炎日" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $rows_reuser['id']?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $rows_reuser['id']?>">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $rows_reuser['id']?>">给他送花</a></dd>
			<dd class="email">邮件：<a href="mailto:<?php echo $rows_reuser['email']?>"><?php echo $rows_reuser['email']?></a></dd>
			<dd class="url">网址：<a href="<?php echo $rows_reuser['url']?>" target="_blank"><?php echo $rows_reuser['url']?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php echo $i+$pagesize*($page-1)?>#</span><?php echo $rows_rearticle['username']?> | 发表于：<?php echo $rows_rearticle['date']?>
			</div>
			<h3>
				主题：<?php echo $rows_rearticle['title']?> 
				<img src="images/icon<?php echo $rows_rearticle['type']?>.gif" alt="icon" />
				<a href="#ree" name="re" title="回复<?php echo $i+$pagesize*($page-1)?>楼的<?php echo $rows_rearticle['username']?>">[回复]</a>
			</h3>
			<div class="detail">
				<?php echo ubb($rows_rearticle['content'])?>
				<?php echo $rows_reuser['autograph_html']?>
			</div>
		</div>
	</div>
	<p class="line"></p>
	<?php 
	$i++;
	}
	mysql_free_result($result);
	?>
	<!-- id=xx& 传入到paging函数里 -->
	<?php paging(1, 'id='.$_GET['id'].'&'); ?>
	
	<!--  发帖框体 必须登录者才能看到   -->
	<?php if($_COOKIE['username']) {?>
	<a name="ree"></a>
	<form method="post" name="post" action="?action=rearticle&id=<?php echo $rows['id']?>">
	<input type="hidden" name="reid" value=<?php echo $rows['id']?> />
	<input type="hidden" name="type" value=<?php echo $rows['type']?> />
	<dl>
		<dt>回帖</dt>
		<dd>标　　题：<input type="text" name="title" class="text" value="RE:<?php echo $rows['title']?>"/> (*必填，2-40位)</dd>
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
	<?php } ?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
