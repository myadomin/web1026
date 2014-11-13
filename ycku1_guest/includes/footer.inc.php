<?php 
//如果没有定义过常量IN_TG 那就退出 防止恶意调用
if(!defined("IN_TG")){
	exit("Access Denied");
}
mysql_close();
?>

<div id="footer">
	<p>本程序执行耗时：<?php echo substr(((get_time() - START_TIME)*1000), 0, 5) ?>毫秒</p>
	<p>版权所有 翻版必究</p>
</div>