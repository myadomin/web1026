<?php 

define('IN_TG', '可以调用');
require dirname(__FILE__).'/includes/common.inc.php';

$category_arr = array('Ajax', 'display', 'HTML5', 'javascript', 'jQuery', 'PHP');

if(in_array($_GET['category'], $category_arr)){
	$_result = mysql_query("
			SELECT 
				id, src, title, time
			FROM 
				articles
			WHERE
				category = '{$_GET['category']}'
			ORDER BY
				title ASC
			");
}else{
	exit('非法进入');
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>博文列表</title>
<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/list.css" />
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/list.js"></script>
</head>
<body>

<?php 
require ROOT_PATH.'includes/header.inc.php';
?>

<div id="top">
	<h2><?php echo $_GET['category'] ?></h2>
	<h4>
	<?php 
	switch ($_GET['category']){
		case 'Ajax';
			echo 'Ajax封装及应用，Ajax瀑布流，<br />Ajax获取后端数据的应用，JSONP应用等。';		
			break;
		case 'display';
			echo '公司及个人的项目展示，<br />css布局展示，web优化，web相关等。';
			break;
		case 'HTML5';
			echo 'HTML5各知识点DEMO，HTML5的LBS应用，<br />canvas应用与canvas游戏，CSS3的2D及3D操作等。';
			break;
		case 'javascript';
			echo 'JS各个知识点的原理DEMO，各种DOM操作效果DEMO，<br />JS面向对象，如何进行组件开发，封装常用函数库等。';
			break;
		case 'jQuery';
			echo 'jQuery基础笔记，jQuery实例DEMO，<br />jQuery源码分析等。';
			break;
		case 'PHP';
			echo 'PHP基础笔记，PHP各知识点DEMO，<br />mysql及mysqli的应用，PHP面向对象，如果构建PHP API等。';
			break;
	}
	?>
	</h4>
</div>

<div id="bar">
	<ul>
		<li><a href="index.php">首页</a>　/</li>  
		<li class="li1"><?php echo $_GET['category'] ?></li>
	</ul>
</div>

<div id="content">
	<div class="content_left">
		<ul class="tabs">
			<li class="active">博文</li>
			<!-- <li>介绍</li>
			<li>下载</li> -->
		</ul>
		<div class="tab1">
			<ul>
			<?php while(!!$_row = mysql_fetch_array($_result)){ 
				//本来substr($_row['time'], 0, 10) 暂时不想让人看到日期 就用0,0
				echo '<li><a target="_blank" href="'.$_row['src'].'">'.$_row['title'].'<span>'.substr($_row['time'], 0, 0).'</span></a></li>';
			} ?>
			</ul>
		</div>
		<div class="tab2">
			介绍
		</div>
		<div class="tab3">
			下载
		</div>
	</div>
	<!-- <div class="content_right">
		预留
	</div> -->
	<div class="content_bottom"><!-- 在这里清除浮动，然后height:100px --></div>
</div>

<?php 
require ROOT_PATH.'includes/footer.inc.php';
?>
 
</body> 
</html>    
      
     
     
     