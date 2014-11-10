<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','manage_set');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//必须是管理员才能登录
is_admin();

//本页点击修改系统设置就post数据到这里  修改数据库系统表  这个必须写在读取系统表前面
if(isset($_GET['action']) == 'set'){
	mysql_query("
			UPDATE system
			SET 
				webname = '{$_POST['webname']}',
				article = '{$_POST['article']}',
				blog = '{$_POST['blog']}',
				photo = '{$_POST['photo']}',
				skin = '{$_POST['skin']}',
				string = '{$_POST['string']}',
				post = '{$_POST['post']}',
				re = '{$_POST['re']}',
				code = '{$_POST['code']}',
				register = '{$_POST['register']}'
			WHERE id=1
			") or die(mysql_error());
	if(mysql_affected_rows() == 1){
		alert_location('系统修改成功', 'manage_set.php');
	}else{
		alert_back('系统修改失败');
	}
}

//读取系统表
$result = mysql_query("
		SELECT webname, article, blog, photo, skin, string, post, re, code, register
		FROM system
		LIMIT 1
		") or die(mysql_error());
$rows = mysql_fetch_array($result, MYSQL_ASSOC);
// print_r($rows);

//根据系统表各个字段值  注意html转义
$_html = array();
$_html['webname'] = htmlspecialchars($rows['webname']);
$_html['string'] = htmlspecialchars($rows['string']);
$_html['article'] = htmlspecialchars($rows['article']);
$_html['blog'] = htmlspecialchars($rows['blog']);
$_html['photo'] = htmlspecialchars($rows['photo']);
$_html['skin'] = htmlspecialchars($rows['skin']);
$_html['post'] = htmlspecialchars($rows['post']);
$_html['re'] = htmlspecialchars($rows['re']);
$_html['code'] = htmlspecialchars($rows['code']);
$_html['register'] = htmlspecialchars($rows['register']);

//根据字段值  形成相应的html输出到页面 
//每页显示文章数
if ($_html['article'] == 5) {
	$_html['article_html'] = '<select name="article"><option value="5" selected="selected">每页5篇</option><option value="10">每页10篇</option></select>';
} elseif ($_html['article'] == 10) {
	$_html['article_html'] = '<select name="article"><option value="5">每页5篇</option><option value="10" selected="selected">每页10篇</option></select>';
}
//每页显示博友数
if ($_html['blog'] == 15) {
	$_html['blog_html'] = '<select name="blog"><option value="15" selected="selected">每页15人</option><option value="20">每页20人</option></select>';
} elseif ($_html['blog'] == 20) {
	$_html['blog_html'] = '<select name="blog"><option value="15">每页15人</option><option value="20" selected="selected">每页20人</option></select>';
}
//每页显示相片数
if ($_html['photo'] == 8) {
	$_html['photo_html'] = '<select name="photo"><option value="8" selected="selected">每页8张</option><option value="12">每页12张</option></select>';
} elseif ($_html['photo'] == 12) {
	$_html['photo_html'] = '<select name="photo"><option value="8">每页8张</option><option value="12" selected="selected">每页12张</option></select>';
}
//皮肤
if ($_html['skin'] == 1) {
	$_html['skin_html'] = '<select name="skin"><option value="1" selected="selected">一号皮肤</option><option value="2">二号皮肤</option><option value="3">三号皮肤</option></select>';
} elseif ($_html['skin'] == 2) {
	$_html['skin_html'] = '<select name="skin"><option value="1">一号皮肤</option><option value="2" selected="selected">二号皮肤</option><option value="3">三号皮肤</option></select>';
} elseif ($_html['skin'] == 3) {
	$_html['skin_html'] = '<select name="skin"><option value="1">一号皮肤</option><option value="2">二号皮肤</option><option value="3" selected="selected">三号皮肤</option></select>';
}
//发帖
if ($_html['post'] == 30) {
	$_html['post_html'] = '<input type="radio" name="post" value="30" checked="checked" /> 30秒 <input type="radio" name="post" value="60" /> 1分钟 <input type="radio" name="post" value="180" /> 3分钟';
} elseif ($_html['post'] == 60) {
	$_html['post_html'] = '<input type="radio" name="post" value="30" /> 30秒 <input type="radio" name="post" value="60" checked="checked" /> 1分钟 <input type="radio" name="post" value="180" /> 3分钟';
} elseif ($_html['post'] == 180) {
	$_html['post_html'] = '<input type="radio" name="post" value="30" /> 30秒 <input type="radio" name="post" value="60" /> 1分钟 <input type="radio" name="post" value="180" checked="checked" /> 3分钟';
}
//回帖
if ($_html['re'] == 15) {
	$_html['re_html'] = '<input type="radio" name="re" value="15" checked="checked" /> 15秒 <input type="radio" name="re" value="30" /> 30秒 <input type="radio" name="re" value="45" /> 45秒';
} elseif ($_html['re'] == 30) {
	$_html['re_html'] = '<input type="radio" name="re" value="15" /> 15秒 <input type="radio" name="re" value="30" checked="checked" /> 30秒 <input type="radio" name="re" value="45" /> 45秒';
} elseif ($_html['re'] == 45) {
	$_html['re_html'] = '<input type="radio" name="re" value="15" /> 15秒 <input type="radio" name="re" value="30" /> 30秒 <input type="radio" name="re" value="45" checked="checked" /> 45秒';
}
//验证码
if ($_html['code'] == 1) {
	$_html['code_html'] =  '<input type="radio" name="code" value="1" checked="checked" /> 启用 <input type="radio" name="code" value="0" /> 禁用';
} else {
	$_html['code_html'] =  '<input type="radio" name="code" value="1" /> 启用 <input type="radio" name="code" value="0" checked="checked"  /> 禁用';
}
//放开注册
if ($_html['register'] == 1) {
	$_html['register_html'] =  '<input type="radio" name="register" value="1" checked="checked" /> 启用 <input type="radio" name="register" value="0" /> 禁用';
} else {
	$_html['register_html'] =  '<input type="radio" name="register" value="1" /> 启用 <input type="radio" name="register" value="0" checked="checked" /> 禁用';
}




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--后台管理中心</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="member">
<?php 
	require ROOT_PATH.'includes/manage.inc.php';
?>
	<div id="member_main">
		<h2>后台管理中心</h2>
		<form method="post" action="?action=set">
		<dl>
			<dd>·网 站 名 称：<input type="text" name="webname" class="text" value="<?php echo $_html['webname']?>" /></dd>
    		<dd>·回帖每页列表数：<?php echo $_html['article_html'];?></dd>
    		<dd>·博客每页列表数：<?php echo $_html['blog_html'];?></dd>
    		<dd>·相册每页列表数：<?php echo $_html['photo_html'];?></dd>
    		<dd>·站点 默认 皮肤：<?php echo $_html['skin_html'];?></dd>
    		<dd>·非法 字符 过滤：<input type="text" name="string" class="text" value="<?php echo $_html['string'];?>" /> (*请用|线隔开)</dd>
			<dd>·每次 发帖 限制：<?php echo $_html['post_html'];?></dd>
			<dd>·每次 回帖 限制：<?php echo $_html['re_html'];?></dd>
			<dd>·是否 启用 验证：<?php echo $_html['code_html'];?></dd>
			<dd>·是否 开放 注册：<?php echo $_html['register_html'];?></dd>
			<dd><input type="submit" value="修改系统设置" class="submit" /></dd>
		</dl>
		</form>
	</div>
</div>


<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
