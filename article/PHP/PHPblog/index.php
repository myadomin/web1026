<?php 
define('IN_TG',"任意东西");  //定义一个常量 这句一定要写在下面判断之前
define("SCRIPT","index");    //定义一个常量 便于调用title.inc.php
if(!defined('IN_TG')){       //如果”IN_TG“这个常量之前没定义过 就退出程序 并输出Access Denied 
	exit('Access Denied!');    //这样就只有通过index.php这个文档才能调用/includes/header.inc.php等文件了 因为只有index.php才定义了这个常量
}                            //在header.inc.php里写也写上这个判断 但是不定义常量 这样就无法通过 ../../includes/header.inc.php路径直接访问他们了
session_start();           //注意文件如果保存为带BOM头的UTF8 那设置session或者header就会报错
require dirname(__FILE__).'/includes/common.inc.php';     //转化为硬路径 在common.inc.php中集中配置一些东西 
global $_system;

//读取新进会员的数据
$_result1 = mysql_query(
		"SELECT 
			tg_id, tg_username, tg_email, tg_url, tg_sex, tg_face 
		FROM 
			tg_user 
		ORDER BY  
			tg_id 
		DESC 
		LIMIT 
			1
		");
$_rows1 = mysql_fetch_array($_result1);  //为了避免和下面的$_rows冲突 所以用$_rows1

//读取帖子
_page("SELECT tg_id FROM tg_article WHERE tg_reid=0", $_system['article']);  //得出所有分页需要的数据  必须是主题帖 所以tg_reid=0
global $_pagenum, $_pagesize;  //这里其实做不做全局都无所谓 因为_page函数里面已经做了全局 这里是认识的 只是为了IDE不警告而已
$_result = mysql_query("
		SELECT 
			tg_id, tg_type, tg_title, tg_readcount, tg_commendcount
		FROM 
			tg_article
		WHERE
			tg_reid=0    
		ORDER BY 
			tg_id DESC 
		LIMIT 
			$_pagenum,$_pagesize
");  //注意这里 WHERE tg_reid=0  只读取主题帖

//显示最新图片 必须是公开相册的图片
//查找数据库的时候 tg_sid in(xx) xx就是tg_dir表中 tg_type=0的那些行的tg_id
$_result_photo = mysql_query("
		SELECT 
			tg_id, tg_name, tg_url
		FROM
			tg_photo
		WHERE
			tg_sid in(SELECT tg_id FROM tg_dir WHERE tg_type=0)
		ORDER BY
			tg_date DESC
		LIMIT
			1
		");
$_rows_photo = mysql_fetch_array($_result_photo);




?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--首页</title>
<?php 
	require ROOT_PATH."includes/title.inc.php";    //把三句link都写到title.inc.php里面去
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>

<?php 
	require ROOT_PATH.'includes/header.inc.php';   //在commom.inc.php中定义了常量ROOT_PATH 在这里也用硬路径
?>

<div id="list">
	<h2>帖子列表</h2>
	<a href="post.php" class="post">发表帖子</a>
	<ul class="article">
		<?php while (!!$_rows = mysql_fetch_array($_result)) { ?>
		<li class="icon<?php echo $_rows['tg_type'] ?>">
			<em>阅读数(<strong><?php echo $_rows['tg_readcount'] ?></strong>) 评论数(<strong><?php echo $_rows['tg_commendcount'] ?></strong>)</em> 
			<a href="article.php?id=<?php echo $_rows['tg_id'] ?>"><?php echo _title($_rows['tg_title']).'...' ?></a>
		</li>
		<?php } ?>
	</ul>
	<?php 
	mysql_free_result($_result);
	_paging(1);  //调用这个就是数字分页
	_paging(2);  //调用这个就是文字分页
	?>
</div>

<div id="user">
	<h2>新进会员：<?php echo $_rows1['tg_username']?>（<?php echo $_rows1['tg_sex']?>）</h2>
	<dl>
		<dd class="user"><?php echo $_rows1['tg_username']?>（<?php echo $_rows1['tg_sex']?>）</dd>
		<dt><img src="<?php echo $_rows1['tg_face']?>" alt="<?php echo $_rows1['tg_username']?>" /></dt>
		<dd class="message"><a href="javascript:" name="message" title="<?php echo $_rows1['tg_id']?>">发消息</a></dd>
		<dd class="friend"><a href="javascript:" name="friend" title="<?php echo $_rows1['tg_id']?>">加为好友</a></dd>
		<dd class="guest">写留言</dd>
		<dd class="flower"><a href="javascript:" name="flower" title="<?php echo $_rows1['tg_id']?>">给他送花</a></dd>
		<dd class="emai">邮箱：<?php echo $_rows1['tg_email']?></dd>
		<dd class="url">网址：<?php echo $_rows1['tg_url']?></dd>
	</dl>
</div>

<div id="pics">
	<h2>最新图片 -- <?php echo $_rows_photo['tg_name']?></h2>
	<a href="photo_detail.php?id=<?php echo $_rows_photo['tg_id']?>">
		<img src="thumb.php?filename=<?php echo $_rows_photo['tg_url']?>&percent=0.4" />
	</a>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
