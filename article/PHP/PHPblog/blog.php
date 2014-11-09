<?php
define('IN_TG',"任意东西"); 
define("SCRIPT","blog");   
require dirname(__FILE__).'/includes/common.inc.php';
session_start();
global $_system;

_page("SELECT tg_id FROM tg_user", $_system['blog']);  //得出所有分页需要的数据
global $_pagenum, $_pagesize;  //这里其实做不做全局都无所谓 因为_page函数里面已经做了全局 这里是认识的 只是为了IDE不警告而已
$_result = mysql_query("
		SELECT 
			tg_username, tg_sex, tg_face, tg_id 
		FROM 
			tg_user 
		ORDER BY 
			tg_id DESC 
		LIMIT 
			$_pagenum,$_pagesize
		");
//从数据库里提取数据 从表tg_user提取g_username, tg_sex, tg_face字段
//ORDER BY tg_id DESC 按注册id降序提取 后注册的先提取 不加DESC就是默认的id从小到大提取 先注册的先提取  LIMIT X,10 从第X行开始只显示10行数据

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--博友</title>
<?php 
require ROOT_PATH."includes/title.inc.php";    //把三句link都写到title.inc.php里面去
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>

<?php 
require ROOT_PATH.'includes/header.inc.php';   //在commom.inc.php中定义了常量ROOT_PATH 在这里也用硬路径
?>

<div id="blog">
	<h2>博友列表</h2> 
<!-- 	有多少行数据 就循环多少次 每循环一次就读取一行 然后指针下移动一行 -->
	<?php while (!!@$_rows = mysql_fetch_array($_result, MYSQL_ASSOC)) { ?>  
	<dl>
		<dd class="user"><?php echo $_rows['tg_username'] ?>（<?php echo $_rows['tg_sex'] ?>）</dd>
		<dt><img src="<?php echo $_rows['tg_face'] ?>" alt="炎日" /></dt>
		<dd class="message"><a href="javascript:" name="message" title="<?php echo $_rows['tg_id']?>">发消息</a></dd>
		<dd class="friend"><a href="javascript:" name="friend" title="<?php echo $_rows['tg_id']?>">加为好友</a></dd>
		<dd class="guest">写留言</dd>
		<dd class="flower"><a href="javascript:" name="flower" title="<?php echo $_rows['tg_id']?>">给他送花</a></dd>
	</dl>
	<?php } ?>
	<?php 
	mysql_free_result($_result);
	_paging(1);  //调用这个就是数字分页
	_paging(2);  //调用这个就是文字分页
	?>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>