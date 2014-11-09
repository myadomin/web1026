<?php
define('IN_TG',"任意东西");
define("SCRIPT","member_modify");
require dirname(__FILE__).'/includes/common.inc.php';
header("Content-type:text/html;charset=utf-8");

session_start();
//如果点击了提交 就是开始要修改数据了
if($_GET['action'] == 'modify'){
	_check_code($_POST["code"],$_SESSION["code"]); 
	$_result = mysql_query("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'"); 
	$_rows = mysql_fetch_array($_result);
	if($_rows['tg_uniqid'] != $_COOKIE['uniqid']){  //数据库存储的唯一标示符 如果和之前cookie存的标示符不一致  说明伪造了cookie
		_alert_back('唯一标示符异常');
	}      
	include ROOT_PATH."includes/register.func.php";       
	$_clean = array();  
	$_clean['password'] = _check_modify_password($_POST['password'], 6);
	$_clean["email"] = _check_email($_POST["email"]);
	$_clean["qq"] = _check_qq($_POST["qq"]);
	$_clean["url"] = _check_url($_POST["url"]);
	$_clean["sex"] = $_POST["sex"];
	$_clean["face"] = $_POST["face"];
	//修改完毕 提交到数据库
	if(empty($_clean['password'])){
		mysql_query("UPDATE tg_user SET
				tg_email = '{$_clean["email"]}',
				tg_qq = '{$_clean["qq"]}',
				tg_url = '{$_clean["url"]}',
				tg_sex = '{$_clean["sex"]}',
				tg_face = '{$_clean["face"]}'
				WHERE 
				tg_username = '{$_COOKIE['username']}'
				");
	}else{
		mysql_query("UPDATE tg_user SET 
				tg_password = '{$_clean['password']}',
				tg_email = '{$_clean["email"]}',
				tg_qq = '{$_clean["qq"]}',
				tg_url = '{$_clean["url"]}',
				tg_sex = '{$_clean["sex"]}',
				tg_face = '{$_clean["face"]}'
				WHERE 
				tg_username = '{$_COOKIE['username']}'
				");
	}
	//判断是否修改成功
	if(_affected_rows() == 1){    //如果只影响了数据库的一行 说明修改成功了
		mysql_close(); //关闭数据库 如果点了提交就在这里关闭 如果没提交最后在footer也会关闭数据库
		_location("恭喜你，修改成功","member.php");
	}else{
		mysql_close();
		_location("很遗憾，没有任何被修改","member_modify.php");
	}
}


//只有登录的产生cookie了才能进入页面  直接通过member.php进入页面是非法登录
if(isset($_COOKIE['username'])){
	$_result = mysql_query("SELECT tg_username, tg_sex, tg_face, tg_email, tg_url, tg_qq, tg_reg_time, tg_level FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
	$_rows = mysql_fetch_array($_result);
	if($_rows){   //可能用户登录并cookie保存了一个月 在这一个月内 cookie存在 可是管理员已经删除了此用户的数据库数据 所以要做这个判断
		$_html = array();
		$_html['username'] = htmlspecialchars($_rows['tg_username']);
		$_html['sex'] = htmlspecialchars($_rows['tg_sex']);
		$_html['face'] = htmlspecialchars($_rows['tg_face']);
		$_html['email'] = htmlspecialchars($_rows['tg_email']);
		$_html['url'] = htmlspecialchars($_rows['tg_url']);
		$_html['qq'] = htmlspecialchars($_rows['tg_qq']);
		$_html['reg_time'] = htmlspecialchars($_rows['tg_reg_time']);
		switch($_rows['tg_level']){
			case '0':
				$_html['level'] = '普通用户';
				break;
			case '1':
				$_html['level'] = '管理员';
				break;
			default:
				$_html['level'] = '出错了';
		}
		//重做sex
		if($_html['sex'] == '男'){
			$_html['sex_html'] = '<input type="radio" name="sex" value="男" checked="checked"/> 男　<input type="radio" name="sex" value="女" /> 女';
		}else if($_html['sex'] == '女'){
			$_html['sex_html'] = '<input type="radio" name="sex" value="男" /> 男　 <input type="radio" name="sex" value="女" checked="checked" /> 女';
		}
		//重做face
		$_html['face_html'] = '<select name="face">';
		foreach(range(1,9) as $num){
			$_html['face_html'] .= '<option value="face/m0'.$num.'.gif">face/m0'.$num.'.gif</option>';
		}
		foreach(range(10,64) as $num){
			$_html['face_html'] .= '<option value="face/m'.$num.'.gif">face/m'.$num.'.gif</option>';
		}
		$_html['face_html'] .= '</select>';		
	}else{
		_alert_back('此用户不存在');
	}
}else{
	_alert_back('非法登录');
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--个人中心</title>
<?php
require ROOT_PATH."includes/title.inc.php";    //把三句link都写到title.inc.php里面去
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/member_modify.js"></script>
</head>
<body>
<?php 
require ROOT_PATH.'includes/header.inc.php';   //在commom.inc.php中定义了常量ROOT_PATH 在这里也用硬路径
?>

<div id="member">
	<?php 
	require ROOT_PATH.'includes/member.inc.php';
	?>
	<div id="member_main">
		<h2>会员管理中心</h2>
		<form method="post" action="member_modify.php?action=modify">
			<dl>
				<dd>用 户   名：<?php echo $_html['username'] ?></dd>
				<dd>密　　码：<input type="password" class="text" name="password" /> (留空则不修改)</dd>
				<dd>性　　别：<?php echo $_html['sex_html'] ?></dd>
				<dd>头　　像：<?php echo $_html['face_html'] ?></dd>
				<dd>电子邮件：<input type="text" class="text" name="email" value="<?php echo $_html['email']?>" /></dd>
				<dd>主　　页：<input type="text" class="text" name="url" value="<?php echo $_html['url']?>" /></dd>
				<dd>Q 　 　Q：<input type="text" class="text" name="qq" value="<?php echo $_html['qq']?>" /></dd>
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


