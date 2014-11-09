<?php

//模拟后台数据
$dataArr = array();

for($i=1; $i<=10; $i++){
	$temp = "{
		batch: ".($i).",
		list: [
			{
				src: ['img/1.jpg', 'img/2.jpg', 'img/3.jpg'],
				title: ['新的第".($i)."批图片111', '新的第".($i)."批图片222', '新的第".($i)."批图片333']
			},
			{
				src: ['img/4.jpg', 'img/5.jpg', 'img/6.jpg', 'img/3.jpg'],
				title: ['新的第".($i)."批图片444', '新的第".($i)."批图片555', '新的第".($i)."批图片666', '新的第".($i)."批图片777']
			},
			{
				src: ['img/7.jpg', 'img/8.jpg', 'img/9.jpg'],
				title: ['新的第".($i)."批图片888', '新的第".($i)."批图片999', '新的第".($i)."批图片000']
			}
		]
	}";
	//形成10个json字符串 存入$dataArr数组中 
	array_push($dataArr, $temp);

	//根据不同的?xxxx 输出相应批次的数据
	if($_GET['batch'] == $i){
		echo $dataArr[$i-1];		//例如?batch=2就输出$dataArr[1] 也就是第二批数据
	}

}


?>