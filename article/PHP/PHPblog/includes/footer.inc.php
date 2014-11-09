<?php 
	if(!defined("IN_TG")){
		exit("Access Denied");
	}
	mysql_close();   //如果没有点击注册后就关闭了页面 那就再最后 关闭数据库
?>
<div id="footer">
	<p>本程序执行耗时<?php echo round((_runtime()-START_TIME),4) ?></p>
	<p>版权所有 翻版必究</p>
	<p>本程序由<span>瓢城Web俱乐部</span>提供 源代码可以任意修改或发布 (c) yc60.com</p>
</div>
