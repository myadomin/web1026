<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','blog');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//从$pagenum条数据开始  读取$pagesize条数据
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pagesize = SYS_BLOG;
$pagenum = ($page-1)*$pagesize;
$result = mysql_query("
		SELECT username, sex, face, id
		FROM user 
		ORDER BY reg_time
		DESC
		LIMIT $pagenum, $pagesize
");

//得到所有页数总共有多少条数据  从而得到共多少页  从而决定li循环多少次
$total = mysql_num_rows(mysql_query("SELECT id FROM user"));
$pageabsolute = ceil($total/$pagesize);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--博友</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="blog">
	<h2>博友列表</h2>
	<?php 
	while(!!$rows = mysql_fetch_array($result)) {
	$html = array();
	//通过htmlspecialchars 把< >等特殊字符转义  从而不影响html
	$html['username'] = htmlspecialchars($rows['username']);
	$html['sex'] = htmlspecialchars($rows['sex']);
	$html['face'] = htmlspecialchars($rows['face']);
	?>
	<dl>
		<dd class="user"><?php echo $html['username'] ?>(<?php echo $html['sex'] ?>)</dd>
		<dt><img src="<?php echo $html['face'] ?>" alt="<?php echo $html['username'] ?>" /></dt>
		<dd class="message"><a href="javascript:;" name="message" title="<?php echo $rows['id'] ?>">发消息</a></dd>
		<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $rows['id'] ?>">加为好友</a></dd>
		<dd class="guest">写留言</dd>
		<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $rows['id'] ?>">给他送花</a></dd>
	</dl>
	<?php 
	}
	//这里结果集会获取大量的数据  所以出于优化性能考虑  每次获取完及结果集就销毁
	mysql_free_result($result);
	?>
	<?php paging(1); ?>
	<?php paging(2); ?>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
