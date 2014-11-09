<?php
//模拟数据 写死的
$arr1 = array('1111', '2222', '3333', '4444', '5555');
$arr2 = array('aaaa', 'bbbb', 'cccc', 'dddd', 'eeee');
$arr3 = array('错误');
$fn = $_GET['callback']; 

if($_GET['type'] == 'number'){
	$result = json_encode($arr1);
}else if($_GET['type'] == 'letter'){
	$result = json_encode($arr2);
}else{		//没设置type或者写错type值 
	$result = json_encode($arr3);
}

echo $fn.'('.$result.')';
//例如test.php?type=number&callback=getNumber 
//那就输出getNumber(["1111","2222","3333","4444","5555"]);
//然后再js中定义function getNumber(data){xxxx} 对data进行处理


?>