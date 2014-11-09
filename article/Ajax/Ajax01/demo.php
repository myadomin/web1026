<?php
// header('content-type:text/html;charset="utf-8"');

$news = array(
	array("title"=>"111111111111111", "date"=>"2014,3.15"),
	array("title"=>"111111111111111", "date"=>"2014,3.15"),
	array("title"=>"俄将暂时撤销封锁乌军事基地", "date"=>"2014,3.15"),
	array("title"=>"朝鲜两个小时内向东部海域发射18枚短程导弹", "date"=>"2014,3.15"),
	array("title"=>"上海工商责令尼康在全国下架D600相机", "date"=>"2014,3.15"),
	array("title"=>"广州婴儿安全岛弃婴数量远超负荷暂停试点", "date"=>"2014,3.15"),
	array("title"=>"朝鲜延长军人服役年限解决募兵不足问题", "date"=>"2014,3.15"),
	array("title"=>"松鼠将女孩马尾辫当家女警穿高跟鞋执勤", "date"=>"2014,3.15"),
	array("title"=>"北京煎饼薄脆市场黑作坊生产一个月坏不了", "date"=>"2014,3.15"),
	array("title"=>"朝鲜延长军人服役年限解决募兵不足问题", "date"=>"2014,3.15"),
);

echo JSON_encode($news); 
//$news是数组 通过JSON_encode将他转换为json格式的字符串  
//JSON格式的字符串就是 [{"title":"xxx","date":"xxx"},{},{},{},......]


?>


