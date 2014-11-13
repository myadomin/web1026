<?php

//防止恶意调用
if(!defined("IN_TG")){
	exit("Access Denied");
}

?>

<div id="footer">
	<p>个人邮箱:adomin@163.com　本页执行耗时<?php echo round(get_now_time()- START_TIME, 6)*1000?>毫秒</p>
	<p>粤ICP备14055944号. © 2014-2014 www.web1026.com version:1.0.1</p>
</div>