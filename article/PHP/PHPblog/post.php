<?php
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','post');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");
session_start();

//登录才能发帖
if(!isset($_COOKIE['username'])){
	_location('请先登录', 'login.php');
	exit();
}

//验证帖子相关内容  写入数据库
if($_GET['action'] == 'post'){
	//验证帖子相关内容
	_check_code($_POST["code"],$_SESSION["code"]);
	$_result1 = mysql_query("SELECT tg_uniqid, tg_post_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
	$_rows = mysql_fetch_array($_result1);
	if($_rows['tg_uniqid'] != $_COOKIE['uniqid']){  //数据库存储的唯一标示符 如果和之前cookie存的标示符不一致  说明伪造了cookie
		_alert_back('唯一标示符异常');
	}
	//限时发帖 在发的帖子 写入数据库前做判断  第一次回帖 执行到这里的时候 $_rows['tg_post_time']是默认值0 所以肯定间隔超过60秒
	//_timed(time(), $_COOKIE['post_time'], 60);  //当前发帖的时间  间隔上一次成功发帖的时间  要大于$_second秒
	_timed(time(), $_rows['tg_post_time'], 60);   //数据库方法
	//写入数据库
	include ROOT_PATH."includes/register.func.php";
	$_clean = array();
	$_clean['username'] = $_COOKIE['username'];
	$_clean['type'] =  $_POST['type'];
	$_clean['title'] = _check_post_title($_POST['title']);
	$_clean['content'] = _check_post_content($_POST['content']);
 	$_result = mysql_query("INSERT INTO tg_article (
 				tg_username,
 				tg_type,
 				tg_title,
 				tg_content,
 				tg_date
 			) 
 			VALUES (
 				'{$_clean['username']}',
 				'{$_clean['type']}',
 				'{$_clean['title']}',
 				'{$_clean['content']}',
 				NOW()
 			) ");
 	if(_affected_rows() == 1){    //如果只影响了数据库的一行 说明新增成功了
 		$_clean['id'] = mysql_insert_id();  //得到最近新增的一条数据的id
 		//setcookie('post_time',time());   //发帖成功前 记录成功发帖的时间戳 cookie方法
 		$_clean['post_time'] = time();     //数据库方法 下次再发帖 读取这个字段 看下次发帖时间与这个字段比较
 		mysql_query("
 				UPDATE 
 					tg_user 
 				SET 
 					tg_post_time='{$_clean['post_time']}' 
 				WHERE 
 					tg_username='{$_COOKIE['username']}'
 					");
 		mysql_close();
 		_session_destory();
 		_location("恭喜你，发帖成功", "article.php?id=".$_clean['id']);
 	}else{
 		mysql_close();
 		_session_destory();
 		_alert_back("很遗憾，发帖失败");
 	}
 		
}


?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--发表帖子</title>
<?php 
require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
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
			<dd>
				标　　题：<input type="text" name="title" class="text" /> (*必填，2-40位)
			</dd>
			<dd id="q">
				贴　　图：　<a href="javascript:;">Q图系列[1]</a>　 <a href="javascript:;">Q图系列[2]</a>　 <a href="javascript:;">Q图系列[3]</a>
			</dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php';?>
				<textarea name="content" rows="9"></textarea>
			</dd>
			<dd>
				验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> <input type="submit" class="submit" value="发表帖子" />
			</dd>
		</dl>
	</form>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
