<?php 
session_start();
//定义常量IN_TG 便于调用inc文件
define("IN_TG", true);

//定义需要引入的专有css js
define("SCRIPT", "index");

//引入公共文件 dirname(__FILE__)是当前文件所在的硬路径
require dirname(__FILE__)."/includes/common.inc.php";

//在register.php对于新注册的用户都生成了xml 在这里读取xml
//这里只是学习xml 其实用数据库就可以得到最新注册的用户信息
$xml_str = file_get_contents("new.xml");
//将得到的xml字符串转为xml对象
$xml_obj = simplexml_load_string($xml_str, 'SimpleXMLElement');
$html['id'] = $xml_obj->id;
$html['username'] = $xml_obj->username;
$html['sex'] = $xml_obj->sex;
$html['face'] = $xml_obj->face;
$html['email'] = $xml_obj->email;
$html['url'] = $xml_obj->url;

//读取显示最新上传的图片  并且是非私密的  sql两层查询
$result_photo = mysql_query("
		SELECT id, name, url
		FROM photo
		WHERE sid in(SELECT id FROM dir WHERE type=0)
		ORDER BY date
		DESC
		LIMIT 1
		");
$rows_photo = mysql_fetch_array($result_photo);

//读取帖子列表
//从$pagenum条数据开始  读取$pagesize条数据  必须reid=0(主题帖)才显示
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pagesize = 10;
$pagenum = ($page-1)*$pagesize;
$result = mysql_query("
		SELECT type, title, readcount, commentcount, id, date, reid
		FROM article
		WHERE reid=0
		ORDER BY date
		DESC
		LIMIT $pagenum, $pagesize
		");

//得到所有页数总共有多少条数据  从而得到共多少页  从而决定li循环多少次
$total = mysql_num_rows(mysql_query("SELECT id FROM article WHERE reid=0"));
$pageabsolute = ceil($total/$pagesize);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--首页</title>
<?php include ROOT_PATH.'includes/title.inc.php'; ?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>

<?php 
include ROOT_PATH.'includes/header.inc.php';
?>

<div id="list">
	<h2>帖子列表</h2>
	<a href="post.php" class="post">发表帖子</a>
	<ul class="article">
		<?php while(!!$rows = mysql_fetch_array($result)) {?>
		<li class="icon<?php echo $rows['type']?>">
			<em>阅读数(<strong><?php echo $rows['readcount']?></strong>) 评论数(<strong><?php echo $rows['commentcount']?></strong>)</em> 
			<a href="article.php?id=<?php echo $rows['id']?>"><?php echo $rows['title']?></a>
		</li>
		<?php 
		}
		mysql_free_result($result);
		?>
	</ul>
	<?php paging(1); ?>
</div>

<div id="user">
	<h2>新进会员</h2>
	<dl>
		<dd class="user"><?php echo $html['username'] ?>(<?php echo $html['sex'] ?>)</dd>
		<dt><img src="<?php echo $html['face'] ?>" alt="<?php echo $html['username'] ?>" /></dt>
		<dd class="message"><a href="javascript:;" name="message" title="<?php echo $html['id'] ?>">发消息</a></dd>
		<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $html['id'] ?>">加为好友</a></dd>
		<dd class="guest">写留言</dd>
		<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $html['id'] ?>">给他送花</a></dd>
		<dd class="email">邮件：<?php echo $html['email'] ?></dd>
		<dd class="url">网址：<a href="#"><?php echo $html['url'] ?></a></dd>
	</dl>
</div>

<div id="pics">
	<h2>最新图片 -- <?php echo $rows_photo['name']?></h2>
	<a href="photo_detail.php?id=<?php echo $rows_photo['id']?>">
		<img src="thumb.php?filename=<?php echo $rows_photo['url']?>&percent=0.3" alt="" />
	</a>
</div>

<?php 
include ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
