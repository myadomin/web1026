<?php
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','member_modify');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';

//没登陆的不能进入
if(!$_COOKIE['username']){
	alert_back('请先登录');
}

//进入此页面后 读取数据库显示相应值
$result = mysql_query("
			SELECT username, sex, face, email, url, qq, reg_time, level, switch, autograph
			FROM user
			WHERE username='{$_COOKIE['username']}'
		") or die(mysql_error());
$rows = mysql_fetch_array($result, MYSQL_ASSOC);
if(!$rows){
	alert_back('此用户不存在');
}
$html = array();
$html['username'] = htmlspecialchars($rows['username']);
$html['sex'] = htmlspecialchars($rows['sex']);
$html['face'] = htmlspecialchars($rows['face']);
$html['email'] = htmlspecialchars($rows['email']);
$html['url'] = htmlspecialchars($rows['url']);
$html['qq'] = htmlspecialchars($rows['qq']);
$html['switch'] = htmlspecialchars($rows['switch']);
$html['autograph'] = htmlspecialchars($rows['autograph']);
//性别选择
if ($html['sex'] == '男') {
	$html['sex_html'] = '<input type="radio" name="sex" value="男" checked="checked" /> 男 <input type="radio" name="sex" value="女" /> 女';
} elseif ($html['sex'] == '女') {
	$html['sex_html'] = '<input type="radio" name="sex" value="男" /> 男 <input type="radio" name="sex" value="女" checked="checked" /> 女';
}
//头像选择
$html['face_html'] = '<select name="face">';
foreach (range(1,9) as $_num) {
	$html['face_html'] .= '<option value="face/m0'.$_num.'.gif">face/m0'.$_num.'.gif</option>';
}
foreach (range(10,64) as $_num) {
	$html['face_html'] .= '<option value="face/m'.$_num.'.gif">face/m'.$_num.'.gif</option>';
}
$html['face_html'] .= '</select>';
//签名开关
if ($html['switch'] == 1) {
	$html['switch_html'] = '<input type="radio" checked="checked" name="switch" value="1" /> 启用 <input type="radio" name="switch" value="0" /> 禁用';
} elseif ($html['switch'] == 0) {
	$html['switch_html'] = '<input type="radio" name="switch" value="1" /> 启用 <input type="radio" name="switch" value="0" checked="checked" /> 禁用';
}

//如果点击了 提交修改
if($_GET['action'] == 'modify'){
	//验证验证码
	check_code($_POST['code'], $_SESSION['code']);
	//引入验证函数库
	include ROOT_PATH.'includes/check.inc.php';
	//表单数据
	$clean = array();
	$clean['password'] = check_modify_password($_POST['password']);
	$clean['sex'] = $_POST['sex'];
	$clean['face'] = $_POST['face'];
	$clean['email'] = check_email($_POST['email']);
	$clean['qq'] = check_qq($_POST['qq']);
	$clean['url'] = check_url($_POST['url']);
	$clean['switch'] = $_POST['switch'];
	$clean['autograph'] = $_POST['autograph'];
	//修改post来的数据  密码为空就不修改
	if(empty($clean['password'])){
		mysql_query("
			UPDATE user
			SET sex = '{$clean['sex']}',
				face = '{$clean['face']}',
				email = '{$clean['email']}',
				qq = '{$clean['qq']}',
				url = '{$clean['url']}',
				switch = '{$clean['switch']}',
				autograph = '{$clean['autograph']}'
				WHERE username = '{$_COOKIE['username']}'
		") or die(mysql_error());
	}else{
		mysql_query("
			UPDATE user
			SET password = '{$clean['password']}',
				sex = '{$clean['sex']}',
				face = '{$clean['face']}',
				email = '{$clean['email']}',
				qq = '{$clean['qq']}',
				url = '{$clean['url']}',
				switch = '{$clean['switch']}',
				autograph = '{$clean['autograph']}'
			WHERE username = '{$_COOKIE['username']}'
		");
	}
	//查看修改是否成功
	if(mysql_affected_rows() == 1){
		alert_location('恭喜修改成功', 'member.php');
	}else{
		alert_location('没有任何被修改', 'member_modify.php');
	}
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo WEBNAME?>--个人中心</title>
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/member_modify.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="member">
	<?php 
		require ROOT_PATH.'includes/member.inc.php';
	?>
	<div id="member_main">
		<h2>会员管理中心</h2>
		<form method="post" action="?action=modify">
		<dl>
			<dd>用 户 名：<?php echo $html['username']?></dd>
			<dd>密　　码：<input type="password" class="text" name="password" value="" /> （留空则不修改）</dd>
			<dd>性　　别：<?php echo $html['sex_html']?></dd>
			<dd>头　　像：<?php echo $html['face_html']?></dd>
			<dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $html['email']?>" /></dd>
			<dd>主　　页：<input type="text" class="text" name="url" value="<?php echo $html['url']?>" /></dd>
			<dd>Q 　 　Q：<input type="text" class="text" name="qq" value="<?php echo $html['qq']?>" /></dd>
			<dd>个性签名：<?php echo $html['switch_html']?> (可以使用UBB代码)
				<p><textarea name="autograph"><?php echo $html['autograph']?></textarea></p>
			</dd>
			<dd>验 证 码：<input type="text" name="code" class="text yzm"  /> <img src="code.php" id="code" /></dd>
			<dd><input type="submit" class="submit" value="修改资料" /></dd>
		</dl>
		</form>
	</div>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
