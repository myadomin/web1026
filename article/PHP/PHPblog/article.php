<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','article');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");	
session_start();
	
//处理回帖
if ($_GET['action'] == 'rearticle') {
	//验证帖子相关内容
	_check_code($_POST["code"],$_SESSION["code"]);
	$_result1 = mysql_query("SELECT tg_uniqid, tg_article_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
	$_rows = mysql_fetch_array($_result1);
	if($_rows['tg_uniqid'] != $_COOKIE['uniqid']){  //数据库存储的唯一标示符 如果和之前cookie存的标示符不一致  说明伪造了cookie
		_alert_back('唯一标示符异常');
	}
	//限制回帖间隔必须大于20秒 在回帖写入数据库前做判断 第一次回帖 执行到这里的时候 $_rows['tg_article_time']是默认值0 所以肯定间隔超过20秒
	//_timed(time(), $_COOKIE['article_time'], 20);
	_timed(time(), $_rows['tg_article_time'], 20);   //数据库方法
	include ROOT_PATH."includes/register.func.php";
	$_clean = array();
	$_clean['reid'] = $_POST['reid'];  //<input type="hidden" name="reid" value="<?php echo $_clean['reid']
	$_clean['username'] = $_COOKIE['username']; //通过上面的html语句 这里POST接收到了reid 也就是这个主题帖的$_rows['tg_id']
	$_clean['type'] =  $_POST['type'];
	$_clean['title'] = _check_post_title($_POST['title']);
	$_clean['content'] = _check_post_content($_POST['content']);
 	//写入数据库 通过reid 就写入了一个tg_reid=这个主题帖的tg_id的回帖进入了数据库
 	$_result = mysql_query("INSERT INTO tg_article (
 				tg_reid,
 				tg_username,
 				tg_type,
 				tg_title,
 				tg_content,
 				tg_date
 			) 
 			VALUES (
 				'{$_clean['reid']}',
 				'{$_clean['username']}',
 				'{$_clean['type']}',
 				'{$_clean['title']}',
 				'{$_clean['content']}',
 				NOW()
 			) ");
 	if (_affected_rows() == 1) {
 		mysql_query("       
 				UPDATE 
 					tg_article 
 				SET 
 					tg_commendcount=tg_commendcount+1 
 				WHERE 
 					tg_reid=0 
 				AND 
 					tg_id='{$_clean['reid']}'
 				"); //发帖成功前 就累加一次评论量
 		$_article_time = time();
 		mysql_query("
 				UPDATE 
 					tg_user
 				SET
 					tg_article_time= '{$_article_time}'
 				WHERE
 					tg_username = '{$_COOKIE['username']}'
 				");
 		mysql_close();
 		setcookie("article_time", time());  //回帖成功前 记录回帖成功时间
 		_location('回帖成功！','article.php?id='.$_clean['reid']); //通过上面 接收到了reid reid就是这个帖子的tg_id所以还是回到这个页面
 	} else {
 		mysql_close();
 		_alert_back('回帖失败！');
 	}
}


//post.php通过?id=xxx传值过来 这里接收 根据id提取数据库的数据
if(isset($_GET['id'])){   //如果有设置?id=xx
	//读取帖子表的字段信息  只能读取相应id的 而且是主题帖 
	$_result = mysql_query("
			SELECT 
				tg_id, 
				tg_reid, 
				tg_username, 
				tg_type, 
				tg_title, 
				tg_content, 
				tg_readcount, 
				tg_commendcount, 
				tg_date,
				tg_last_modify_date
			FROM 
				tg_article 
			WHERE 
				tg_reid=0  
			AND
				tg_id='{$_GET['id']}'
	");
	$_rows = mysql_fetch_array($_result);  //上面得到的结果集是传过来的id 这个id就是在post.php中新增一行帖子数据对应的id 
	if(!$_rows){
		_alert_back('不存在此帖子');
	}
	
	//帖子读取成功后修改数据阅读量字段  加1
	mysql_query("UPDATE tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
	$_clean = array();
	$_clean['reid'] = $_rows['tg_id'];   //在发完主题帖进入这个页面后 就把这个帖子的id 赋值给reid 
	$_clean['username'] = $_rows['tg_username']; //便于发回帖的时候 post这个reid给到上面的回帖处理
	$_clean['type'] = $_rows['tg_type'];
	$_clean['title'] = $_rows['tg_title'];
	$_clean['content'] = $_rows['tg_content'];
	$_clean['readcount'] = $_rows['tg_readcount'];
	$_clean['commendcount'] = $_rows['tg_commendcount'];
	$_clean['date'] = $_rows['tg_date'];
	$_clean['last_modify_date'] = $_rows['tg_last_modify_date'];
	
	//创建一个全局变量，做个带参的分页
	global $_id;
	$_id = 'id='.$_clean['reid'].'&';
	
	//读取用户表的字段信息
	$_result = mysql_query("
			SELECT 
				tg_id, tg_username, tg_sex, tg_face, tg_email, tg_url 
			FROM 
				tg_user 
			WHERE
				tg_username = '{$_clean['username']}' 
	");
	$_rows = mysql_fetch_array($_result);  //读取这个用户的信息 这个用户的用户名等于提取帖子表中用户名字段
	$_clean['userid'] = $_rows['tg_id'];   //userid用于点击发消息等的时候 传值给message.php?id=xxx页面
 	$_clean['sex'] = $_rows['tg_sex'];
 	$_clean['face'] = $_rows['tg_face'];
 	$_clean['email'] = $_rows['tg_email'];
 	$_clean['url'] = $_rows['tg_url'];
 		
 	//如果登陆人就是发帖人 那就可以修改 并且加上a链接 点击进入修改页面 并传值 id=帖子id
 	if($_clean['username'] == $_COOKIE['username']){
 		$_clean['subject_modify'] = '[<a href="article_modify.php?id='.$_clean['reid'].'">修改</a>]　';
 	}
 	
 	//读取最后修改信息
 	if ($_clean['last_modify_date'] != '0000-00-00 00:00:00') {
 		$_clean['last_modify_date_string'] = '本贴已由['.$_clean['username'].']于'.$_clean['last_modify_date'].'修改过！';
 	}
 	
	//读取回帖的信息并输出
 	_page("SELECT tg_id FROM tg_article WHERE tg_reid='{$_clean['reid']}'", 3);  //得出所有分页需要的数据
 	global $_pagenum, $_pagesize, $_page;
	$_result1 = mysql_query("
			SELECT 
				tg_username, tg_type, tg_title, tg_content, tg_date
			FROM 
				tg_article 
			WHERE 
				tg_reid='{$_clean['reid']}' 
			ORDER BY 
				tg_date ASC 
			LIMIT 
				$_pagenum,$_pagesize
	");	
 	
}else{         //如果没有 ?id=xx
	_alert_back('非法提交');
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--帖子详情</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<!-- 主题帖 -->
<div id="article">
	<h2>帖子详情</h2> 
	<?php if($_page == 1) {  //如果是第一页 才显示主题帖?>
	<div id="subject">
		<dl>
			<dd class="user"><?php echo $_clean['username'] ?>(<?php echo $_clean['sex'] ?>)</dd>
			<dt><img src="<?php echo $_clean['face'] ?>" alt="<?php echo $_clean['username'] ?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_clean['userid'] ?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_clean['userid'] ?>">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_clean['userid'] ?>">给他送花</a></dd>
			<dd class="email">邮件：<a href="####"><?php echo $_clean['email'] ?></a></dd>
			<dd class="url">网址：<a href="###" target="_blank"><?php echo $_clean['url'] ?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php echo $_clean['subject_modify'] ?>1#</span><?php echo $_clean['username'] ?> | 发表于：2009-04-24 00:26:42
			</div>
			<h3>
				<?php echo $_clean['title'] ?> 
				<img src="images/icon<?php echo $_clean['type'] ?>.gif" alt="icon" />
			</h3>
			<div class="detail">
				<?php echo _ubb($_clean['content']) //内容部分 解析ubb代码?>
			</div>
			<div class="read">
				<p><?php echo $_clean['last_modify_date_string'] ?></p>
				阅读量(<?php echo $_clean['readcount'] ?>) 评论量(<?php echo $_clean['commendcount'] ?>)
			</div>
		</div>
	</div>
	<p class="line"></p>
	<?php } ?>
	
<!-- 	回帖 -->
	<?php  //输出回帖的内容 和回帖人的信息
	$_i = 2;
	while (!!@$_rows = mysql_fetch_array($_result1, MYSQL_ASSOC)) {
	$_username = $_rows['tg_username'];  //提取用户名
	if (!!$_rows2 = _fetch_array(
					"SELECT
							tg_id,
							tg_sex,
							tg_face,
							tg_email,
							tg_url
					   FROM
							tg_user
						WHERE
							tg_username='$_username'
	")) {
		//提取用户信息  查找用户表中 当前用户名的那行数据 就是这个用户的信息
		$_clean['userid'] = $_rows2['tg_id'];
		$_clean['sex'] = $_rows2['tg_sex'];
		$_clean['face'] = $_rows2['tg_face'];
		$_clean['email'] = $_rows2['tg_email'];
		$_clean['url'] = $_rows2['tg_url'];
		$_clean['username'] = $_username;
	}else{
		//这个用户可能已经被删除了
	}
	?> 
	<div class="re">
		<dl>
			<dd class="user"><?php echo $_clean['username'] ?>(<?php echo $_clean['sex'] ?>)</dd>
			<dt><img src="<?php echo $_clean['face'] ?>" alt="<?php echo $_clean['username'] ?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_clean['userid'] ?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_clean['userid'] ?>">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_clean['userid'] ?>">给他送花</a></dd>
			<dd class="email">邮件：<a href="####"><?php echo $_clean['email'] ?></a></dd>
			<dd class="url">网址：<a href="###" target="_blank"><?php echo $_clean['url'] ?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php echo $_i+($_page-1)*$_pagesize ?>#</span><?php echo $_rows['tg_username'] ?> | 发表于：<?php echo $_rows['tg_date']?>
			</div>
			<h3><?php echo $_rows['tg_title'] ?> <img src="images/icon<?php echo $_clean['type'] ?>.gif" alt="icon" /></h3>
			<div class="detail">
				<?php echo _ubb($_rows['tg_content']) ?>
			</div>
		</div>
	</div>
	<p class="line"></p>
	<?php
	$_i++; }   //计算回帖楼层 累加
	?>
	<?php 
	mysql_free_result($_result1);
	_paging(1);  //调用这个就是数字分页
	_paging(2);  //调用这个就是文字分页
	?>
	
<!-- 	回帖框体 -->
	<?php if (isset($_COOKIE['username'])) {?>
	<form method="post" action="?action=rearticle">
		<input type="hidden" name="reid" value="<?php echo $_clean['reid']?>" />
		<input type="hidden" name="type" value="<?php echo $_clean['type']?>" />
		<dl>
			<dd>标　　题：<input type="text" name="title" class="text" value="RE:<?php echo $_clean['title']?>" /> (*必填，2-40位)</dd>
			<dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a>　 <a href="javascript:;">Q图系列[2]</a>　 <a href="javascript:;">Q图系列[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php'?>
				<textarea name="content" rows="9"></textarea>
			</dd>
			<dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="发表帖子" /></dd>
		</dl>
	</form>
	<?php }?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
