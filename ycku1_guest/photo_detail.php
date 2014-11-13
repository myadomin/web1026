<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_detail');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';


//图片评论  增加到数据库表photo_comment
if($_GET['action'] == 'rephoto'){
	//验证验证码
	check_code($_POST['code'], $_SESSION['code']);
	
	//将post过来的回帖数据存入数据库
	mysql_query("
		INSERT INTO photo_comment(title, content, sid, username, date)
		VALUES (
			'{$_POST['title']}', 
			'{$_POST['content']}', 
			'{$_POST['sid']}', 
			'{$_COOKIE['username']}', 
			NOW()
			)
	") or die(mysql_error());
	if(mysql_affected_rows() != 1){
		alert_back('评论失败');
	}
	
	//评论量加1 跳转
	mysql_query("
			UPDATE photo
			SET commentcount = commentcount + 1
			WHERE id = '{$_POST['sid']}'
			") or die(mysql_error());
	alert_location('评论成功', 'photo_detail.php?id='.$_POST['sid']);
}


//根据photo_show传过来的图片id 显示大图  显示评论 分页
if(isset($_GET['id'])){
	$result = mysql_query("
			SELECT name, url, content, sid, username, date, readcount, commentcount, id
			FROM photo
			WHERE id='{$_GET['id']}'
			LIMIT 1
			") or die(mysql_error());
	if(!$rows = mysql_fetch_array($result)){
		alert_back('不存在此图片');
	}
	
	//防止先查看公开相册某张图片 然后改变id值  穿插查看私密相册的某张图片
	$result_type = mysql_query("
			SELECT type
			FROM dir
			WHERE id = '{$rows['sid']}'
			LIMIT 1 
			");
	$rows_type = mysql_fetch_array($result_type);
	//判断是否是私密相册  
	if($rows_type['type']){
		//如果是私密  没有对应相册的cookie存在  并且不是管理员  就不让访问
		if(!isset($_COOKIE['photo_pass'.$rows['sid']]) && !isset($_SESSION['admin'])){
			alert_back('非法访问');
		}
	}
	
	//浏览量加1
	mysql_query("
			UPDATE photo
			SET readcount = readcount + 1
			WHERE id='{$_GET['id']}'
			LIMIT 1
			") or die(mysql_error());
	
	//显示评论  分页
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
	$pagesize = 3;
	$pagenum = ($page-1)*$pagesize;
	$result_re = mysql_query("
			SELECT id, title, content, sid, username, date
			FROM photo_comment
			WHERE sid = '{$_GET['id']}'
			ORDER BY date
			DESC
			LIMIT $pagenum, $pagesize
			") or die(mysql_error());
	//得到所有页数总共有多少条数据  从而得到共多少页  从而决定li循环多少次
	$total = mysql_num_rows(mysql_query("SELECT id FROM photo_comment WHERE sid = '{$_GET['id']}'"));
	$pageabsolute = ceil($total/$pagesize);
	
	//找到上一页的id 提取此目录下  比自己大的id中  最小的那个
	$result_preid = mysql_query("
			SELECT min(id)
			AS id
			FROM photo
			WHERE sid = '{$rows['sid']}'
			AND id > '{$rows['id']}'
			") or die(mysql_error());
	$rows_preid = mysql_fetch_array($result_preid);
// 	echo $rows_preid['id'];
	if(!empty($rows_preid['id'])){
		$preid = '<a href="?id='.$rows_preid['id'].'#top">上一页</a>';
	}else{
		$preid = '<span>到头了</span>';
	}
	
	//找到下一页的id 提取此目录下  比自己小的id中  最大的那个
	$result_nextid = mysql_query("
			SELECT max(id)
			AS id
			FROM photo
			WHERE sid = '{$rows['sid']}'
			AND id < '{$rows['id']}'
			") or die(mysql_error());
	$rows_nextid = mysql_fetch_array($result_nextid);
	if(!empty($rows_nextid['id'])){
		$nextid = '<a href="?id='.$rows_nextid['id'].'#top">下一页</a>';
	}else{
		$nextid = '<span>到底了</span>';
	}
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--图片详情</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<!-- 显示大图 -->
	<h2>图片详情</h2>
	<a name="top" id="top"></a>
	<dl class="detail">
		<dd class="name"><?php echo $rows['name']?></dd>
		<dt><?php echo $preid?><img src="<?php echo $rows['url']?>" /><?php echo $nextid?></dt>
		<dd><a href="photo_show.php?id=<?php echo $rows['sid']?>">[返回列表]</a></dd>
		<dd>
			浏览量(<strong><?php echo $rows['readcount'];?></strong>) 
			评论量(<strong><?php echo $rows['commentcount'];?></strong>) 
			发表于：<?php echo $rows['date']?> 
			上传者：<?php echo $rows['username']?></dd>
		<dd>简介：<?php echo $rows['content']?></dd>
	</dl>
	
	<!-- 显示评论 -->
	<?php 
	$i = 0;
	while (!!$rows_re = mysql_fetch_array($result_re)){
		//提取回帖人信息
		$result_user = mysql_query("
			SELECT username, sex, face, email, url, id
			FROM user
			WHERE username = '{$rows_re['username']}'
			LIMIT 1
		");
		$rows_user = mysql_fetch_array($result_user);
		$i++;
	?>
	<p class="line"></p>
	<div class="re">
		<dl>
			<dd class="user"><?php echo $rows_user['username']?>(<?php echo $rows_user['sex']?>)</dd>
			<dt><img src="<?php echo $rows_user['face']?>" alt="<?php echo $rows_user['username']?>" /></dt>
			<dd class="message"><a href="javascript:;" name="message" title="<?php echo $rows_user['id']?>">发消息</a></dd>
			<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $rows_user['id']?>">加为好友</a></dd>
			<dd class="guest">写留言</dd>
			<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $rows_user['userid']?>">给他送花</a></dd>
			<dd class="email">邮件：<a href="mailto:<?php echo $rows_user['email']?>"><?php echo $rows_user['email']?></a></dd>
			<dd class="url">网址：<a href="<?php echo $rows_user['url']?>" target="_blank"><?php echo $rows_user['url']?></a></dd>
		</dl>
		<div class="content">
			<div class="user">
				<span><?php echo $i + (($page-1) * $pagesize);?>#</span><?php echo $rows_re['username']?> | 发表于：<?php echo $rows_re['date']?>
			</div>
			<h3>主题：<?php echo $rows_re['title']?></h3>
			<div class="detail">
				<?php echo ubb($rows_re['content'])?>
			</div>
		</div>
	</div>
	<?php 
	}
	mysql_free_result($result_re);
	paging(1, 'id='.$_GET['id'].'&');
	?>
	
	<!-- 评论框 -->	
	<?php if (isset($_COOKIE['username'])) {?>
	<p class="line"></p>
	<form method="post" action="?action=rephoto">
		<input type="hidden" name="sid" value="<?php echo $rows['id']?>" />
		<dl class="rephoto">
			<dd>标　　题：<input type="text" name="title" class="text" value="RE:<?php echo $rows['name']?>" /> (*必填，2-40位)</dd>
			<dd id="q">贴　　图：　<a href="javascript:;">Q图系列[1]</a>　 <a href="javascript:;">Q图系列[2]</a>　 <a href="javascript:;">Q图系列[3]</a></dd>
			<dd>
				<?php include ROOT_PATH.'includes/ubb.inc.php'?>
				<textarea name="content" rows="9"></textarea>
			</dd>
			<dd>
				验 证 码：
				<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /> 
				<input type="submit" class="submit" value="发表帖子" />
			</dd>
		</dl>
	</form>
	<?php }?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
