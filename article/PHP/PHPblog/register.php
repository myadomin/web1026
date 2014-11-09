<?php 
define('IN_TG',"任意东西");  //定义一个常量 这句一定要写在下面判断之前
define("SCRIPT","reg");
if(!defined('IN_TG')){       //如果”IN_TG“这个常量之前没定义过 就退出程序 并输出Access Denied 
	exit('Access Denied!');    //这样就只有通过index.php这一级别的文档才能调用/includes/header.inc.php等文件了 因为只有index.php这一级别的文档才定义了这个常量
}                            //在header.inc.php里写也写上这个判断 但是不定义常量 这样就无法通过 ../../includes/header.inc.php路径直接访问他们了
require dirname(__FILE__).'/includes/common.inc.php';     //转化为硬路径 在common.inc.php中集中配置一些东西
_login_status();             //登录状态下 如果有人直接通过register.php或者login.php进入登录或注册页面 不能进入
session_start();            //开启SESSION 接收来自code.php中的$_SESSION["code"] = $_nmsg;

header("Content-type:text/html;charset=utf-8");  
//由于这里还没到html文档的UTF-8定义编码语句 所以先用header()定义一下 
//注意如果这里定义了header 那在他之前的common.inc.php等文件就不能存为带bom头的UTF-8
//存为带bom头的uft-8其实就相当于执行了这句

if($_GET["aaa"] == "bbb"){   //第一层防御：只有这个表单提交才能操作后续 form的action="register.php?aaa=bbb" GET方式附加了aaa=bbb名值对
	_check_code($_POST["code"],$_SESSION["code"]);        //第二层防御：验证验证码
	include ROOT_PATH."includes/register.func.php";       //引入注册函数库 验证及处理各个表单的输入
	$_clean = array();                                    
	$_clean["uniqid"] = _check_uniqid($_POST["uniqid"],$_SESSION["uniqid"]); //第三层防御：唯一标示符
	$_clean["active"] = _sha1_uniqid();    //再产生一个唯一标示符 用于后续的用户激活
	$_clean["username"] = _check_username($_POST["username"],2,20); //通过函数 对$_POST["username"]做一系列的处理 最后返回处理过的$_POST["username"]
	$_clean["password"] = _check_password($_POST["password"],$_POST["notpassword"],6);
	$_clean["question"] = _check_question($_POST["question"],2,20);
	$_clean["answer"] = _check_answer($_POST["question"],$_POST["answer"],2,20);
	$_clean["email"] = _check_email($_POST["email"]);
	$_clean["qq"] = _check_qq($_POST["qq"]);
	$_clean["url"] = _check_url($_POST["url"]);
	$_clean["sex"] = $_POST["sex"];
	$_clean["face"] = $_POST["face"];
	
	//在新增前判断用户名是否已注册  如果此次提交的用户在数据库已经有了 下面这个就返回1
	$_query = mysql_query("SELECT tg_username FROM tg_user WHERE tg_username='{$_clean["username"]}'") or die("SQL错误");
	if(mysql_fetch_array($_query,MYSQL_ASSOC)){
		_alert_back("用户名已被注册");
		exit();
	} 
	
	//新增注册用户信息到数据库的tg_user表格 
	//由于外围的单引号 $_clean["username"]数组元素外面一定要加花括号 如果是变量就不用花括号
	mysql_query(
		"INSERT INTO tg_user(
			tg_uniqid,
			tg_active,
			tg_username,
			tg_password,
			tg_question,
			tg_answer,
			tg_email,
			tg_qq,
			tg_url,
			tg_sex,
			tg_face,
			tg_reg_time,
			tg_last_time,
			tg_last_ip
		) 
		VALUES(
			'{$_clean["uniqid"]}',
			'{$_clean["active"]}',
			'{$_clean["username"]}',
			'{$_clean["password"]}',
			'{$_clean["question"]}',
			'{$_clean["answer"]}',
			'{$_clean["email"]}',
			'{$_clean["qq"]}',
			'{$_clean["url"]}',
			'{$_clean["sex"]}',
			'{$_clean["face"]}',
			NOW(),
			NOW(), 
			'{$_SERVER["REMOTE_ADDR"]}'
		)"
	) or die("写入失败".mysql_error());
	
	if(_affected_rows() == 1){   
		mysql_close(); //关闭数据库 如果点了提交就在这里关闭 如果没提交最后在footer也会关闭数据库
		_location("恭喜你，注册成功","active.php?active=".$_clean['active']); //注册成功 跳转页面
	}else{
		mysql_close();
		_location("很遗憾，注册失败","register.php");
	}
	
}
$_SESSION["uniqid"] = $_uniqid = _sha1_uniqid();

 

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>多用户留言系统--注册</title>
<?php 
	require ROOT_PATH."includes/title.inc.php"      //把三句link都写到title.inc.php里面去
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/register.js"></script>
</head>
<body>
 	
<?php 
	require ROOT_PATH.'includes/header.inc.php';   //在commom.inc.php中定义了常量ROOT_PATH 在这里也用硬路径
?>

<div id="register">
<h2>会员注册</h2>           
<form method="post" action="register.php?aaa=bbb"> 
	<!--方法1：如上采用$_GET["aaa"]获取名aaa的值 判断值是不是bbb 从而做出打印
	<input type="hidden" name="aaa" value="bbb"/>    
	方法2：如上采用隐藏字段，表单是按照post提交的 所以$_POST["aaa"]获取名aaa的值，看值是不是bbb  
	判断$_POST["aaa"] == "bbb"    -->
	<input type="hidden" name="uniqid" value="<?php echo $_uniqid ?>"/>
	<dl>
		<dt>请认真填写一下内容</dt>
		<dd>用 户 名：<input type="text" name="username" class="text" />(*必填，至少两位)</dd>
		<dd>密　　码：<input type="password" name="password" class="text" />(*必填，至少六位)</dd>
		<dd>确认密码：<input type="password" name="notpassword" class="text" />(*必填，同上)</dd>
		<dd>密码提示：<input type="text" name="question" class="text" />(*必填，至少两位)</dd>
		<dd>密码回答：<input type="text" name="answer" class="text" />(*必填，至少两位)</dd>
		<dd>性　　别：<input type="radio" name="sex" value="男" checked="checked" />男 <input type="radio" name="sex" value="女" />女</dd>
		<dd class="face"><input type="hidden" name="face" value="face/m01.gif" id="face_input"/><img src="face/m01.gif" alt="头像选择" id="face_img"/></dd>
		<dd>电子邮件：<input type="text" name="email" class="text" />(*必填)</dd>
		<dd>　Q Q 　：<input type="text" name="qq" class="text" /></dd>
		<dd>主页地址：<input type="text" name="url" class="text" value="http://" /></dd>
		<dd>验 证 码：<input type="text" name="code" class="text yzm"/><img src="code.php" id="code"/></dd>
		<dd><input type="submit" class="submit" value="注册" /></dd>
	</dl>
</form>
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>

</body>
</html>
