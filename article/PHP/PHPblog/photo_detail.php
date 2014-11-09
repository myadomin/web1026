<?php
header("Content-type:text/html;charset=utf-8");
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','photo_detail');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';


//通过photo_detail.php?id=12 接收到了tg_photo中的id值 通过这个id值查找对于的那行数据 以显示对应的图片
if(isset($_GET['id'])){
	$_result = mysql_query("
			SELECT 
				tg_id, tg_name, tg_url, tg_content, tg_sid, tg_username, tg_readcount, tg_commendcount, tg_date
			FROM
				tg_photo
			WHERE
				tg_id='{$_GET['id']}'
			LIMIT
				1
			"); 
	$_rows = mysql_fetch_array($_result);
	if(!$_rows){
		_alert_back('此图片不存在');
	}
	$_html = array();
	$_html['id'] = $_rows['tg_id'];
	$_html['name'] = $_rows['tg_name'];
	$_html['url'] = $_rows['tg_url'];
	$_html['content'] = $_rows['tg_content'];
	$_html['sid'] = $_rows['tg_sid'];
	$_html['username'] = $_rows['tg_username'];
	$_html['readcount'] = $_rows['tg_readcount'];
	$_html['commentcount'] = $_rows['tg_commendcount'];
	$_html['date'] = $_rows['tg_date'];	
	
	//防止加密相册图片穿插访问
	//可以先取得这个图片的sid，也就是它的目录，
	//然后再判断这个目录是否是加密的，
	//如果是加密的，再判断是否有对应的cookie存在，并且对于相应的值
	//管理员不受这个限制
	if (!isset($_SESSION['admin'])) {
		if (!!$_dirs = _fetch_array("SELECT tg_type,tg_id,tg_name FROM tg_dir WHERE tg_id='{$_rows['tg_sid']}'")) {
			if (!empty($_dirs['tg_type']) && $_COOKIE['photo'.$_dirs['tg_id']] != $_dirs['tg_name']) {
				_alert_back('非法操作！');
			}
		} else {
			_alert_back('相册目录表出错了！');
		}
	}
	
	//浏览量更新
	mysql_query("UPDATE tg_photo SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'");
	
	//上一张翻页  在数据库查找结果集的时候 
	//查找当前相册下(WHERE tg_sid='{$_html['sid']}')
	//比当前图片id大的图片id(AND tg_id>'{$_html['id']}')
	//中的最小的id(min(tg_id))的那行数据
	//做为tg_min_id字段(AS tg_min_id)在$_rows_prev数组中输出 必须AS 否则输出不了
	//然后再上一张的a链接?id=php输出$_rows_prev['tg_min_id']
	$_result_prev = mysql_query("
			SELECT 
				min(tg_id) 
			AS
				tg_min_id
			FROM 
				tg_photo 
			WHERE 
				tg_sid='{$_html['sid']}'
			AND
				tg_id>'{$_html['id']}'
			");
	$_rows_prev = mysql_fetch_array($_result_prev);
	if(empty($_rows_prev['tg_min_id'])){    //如果是上一张的id是空了 就是数据库没数据了 没图了的时候
		$_prev = '到头了';
	}else{
		$_prev = '<a href="?id='.$_rows_prev['tg_min_id'].'#pre">[上一张]</a>';
	}
	
	//下一张翻页  在数据库查找结果集的时候 
	//查找当前相册下(WHERE tg_sid='{$_html['sid']}')
	//比当前图片id小的图片id(AND tg_id<'{$_html['id']}')
	//中的最大的id(max(tg_id))的那行数据
	//做为tg_max_id字段(AS tg_max_id)在$_rows_next数组中输出 必须AS 否则输出不了
	//然后再上一张的a链接?id=php输出$_rows_next['tg_max_id']
	$_result_next = mysql_query("
			SELECT 
				max(tg_id) 
			AS
				tg_max_id
			FROM 
				tg_photo 
			WHERE 
				tg_sid='{$_html['sid']}'
			AND
				tg_id<'{$_html['id']}'
			");
	$_rows_next = mysql_fetch_array($_result_next);
	if(empty($_rows_next['tg_max_id'])){    //如果是上一张的id是空了 就是数据库没数据了 没图了的时候
		$_next = '到尾了';
	}else{
		$_next = '<a href="?id='.$_rows_next['tg_max_id'].'#next">[下一张]</a>';
	}
	
	
	
	
}else{
	_alert_back('非法操作');
}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/article.js"></script>
</head>
<body>
<?php 
	require ROOT_PATH.'includes/header.inc.php';
?>

<div id="photo">
	<h2>图片详情</h2>
	<!-- 加锚点 只要其他的a链接 xxx.xxx后面带上#pre或者带上#next a跳转页面就直接跳转到这个位置 锚点不能加在dl里面-->
	<a name="pre"></a><a name="next"></a>
	<!-- 单张图片展示 -->
	<dl class="detail">
		<dd class="name"><?php echo $_html['name'] ?></dd>
		<dt><img src="<?php echo $_html['url'] ?>" /></dt>
		<dd>
			<?php echo $_prev ?>　
			<?php echo $_next ?>
		</dd>
		<!--上面读取了tg_photo表中的tg_sid 所以返回图片列表的?id就是$_html['sid'] -->
		<dd><a href="photo_show.php?id=<?php echo $_html['sid'] ?>">返回列表</a></dd>
		<dd>
			浏览量(<strong><?php echo $_html['readcount'] ?></strong>) 
			评论量(<strong><?php echo $_html['commentcount'] ?></strong>) 
			发表于：<?php echo $_html['date'] ?> 
			上传者：<?php echo $_html['username'] ?>
		</dd>
		<dd>简介：<?php echo $_html['content'] ?></dd>
	</dl>
	
</div>

<?php 
	require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
