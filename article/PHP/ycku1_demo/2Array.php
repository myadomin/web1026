<?php
//数组
	
$userNames = array("李彦宏","周鸿祎","马云","俞敏洪","李开复","我");
echo $userNames;        //不同于js，php是不能直接打印数组的 只能通过下标打印某一个数组里的元素
echo $userNames[2];     //马云
print_r($userNames);    //只能通过这种方式全部打印出来 ( [0] => 李彦宏 [1] => 周鸿祎 [2] => 马云 [3] => 俞敏洪 [4] => 李开复 [5] => 我 )
echo "<br/>";
$userNames[5] = "你大爷";  //改变数组的某项
echo $userNames[5];
echo "<br/>";

$numbers = range(2,9);  //创建一个2到9的整型数字数组
print_r($numbers);	    //Array ( [0] => 2 [1] => 3 [2] => 4 [3] => 5 [4] => 6 [5] => 7 [6] => 8 [7] => 9 ) 
echo "<br/>";
$letters = range("e","j");   //创建一个e到j的字母字符串数组
print_r($letters);           //Array ( [0] => e [1] => f [2] => g [3] => h [4] => i [5] => j ) 
echo "<br/>";

echo count($userNames);      //6 输出数组的长度
echo "<br/>";
for($i=0 ; $i<count($userNames) ; $i++){    //但是如果数组的下标不是 0 1 2 3....那就没办法了 用下面的foreach
	echo $userNames[$i];
	echo "<br/>";	
}
echo "<br/>";

foreach($userNames as $aaa){               //通过foreach遍历数组 不需要管下标
	echo $aaa."<br/>";	 
}
echo "<br/>";

if(is_array($userNames)){                   //如果是数组
	foreach($userNames as $key=>$value){      //as  $aaa=>$bbb也可以 都是变量 只要格式对就行
		echo $key."---".$value."<br/>";	 
	}
}else{                                      //如果不是数组 那一般就是变量 直接打印变量就行
	echo $userNames;
}
echo "<br/>";

//创建自定义的下标（键）并追加数组
$users = array("baidu"=>"李彦宏","taobao"=>"马云","360"=>"周鸿祎");
echo $users["baidu"];
echo $users["360"];
$users["xxx"] = "我";
echo $users["xxx"];    //添加一个数组元素
echo "<br/>";
print_r($users);       //Array ( [baidu] => 李彦宏 [taobao] => 马云 [360] => 周鸿祎 [xxx] => 我 ) 
echo "<br/>";
foreach($users as $aaa=>$bbb){
	echo $aaa."---".$bbb."<br/>";	
}
echo "<br/>";

//each() reset() list() 之前的$users已经被foreach了 这里再对他each就没作用了 所以另外创建一个数组 或者reset()原数组
$usersMan = array("baidu"=>"李彦宏","taobao"=>"马云","360"=>"周鸿祎");   
$eee = each($usersMan);  //each()后 提取出数组的第一个元素 并包装成一个新数组 同时这个数组的指针往下移一步
print_r($eee);           //Array ( [1] => 李彦宏 [value] => 李彦宏 [0] => baidu [key] => baidu ) 
echo "<br/>";
$eee = each($usersMan);  //再each()$userMan这个数组的时候 指针已经在之前往下了一步 所以再打印$eee变为如下
print_r($eee);           //Array ( [1] => 马云 [value] => 马云 [0] => taobao [key] => taobao ) 
echo "<br/>";
	
reset($usersMan);        //reset这个数组后 之前each改变的指针指向回到初始位置 
$eee = each($usersMan);  //所以再each这个数组后 指针还是在初始位置的
print_r($eee);           //所以还是打印Array ( [1] => 李彦宏 [value] => 李彦宏 [0] => baidu [key] => baidu ) 
echo "<br/>";
	
reset($usersMan);        //重置之前的each 让指针指向初始位置
$kkk = each($usersMan);  
print_r($kkk);           						//Array ( [1] => 李彦宏 [value] => 李彦宏 [0] => baidu [key] => baidu )
list($company,$name) = $kkk;        //list(xx,xx)只能识别$kkk这个新数组的0 1 2...之类的下标 并把下标赋给$company 把值赋给$name
echo $company."---".$name."<br/>";  //所以输出 baidu---李彦宏
	
$kkk = each($usersMan);  
list($company,$name) = $kkk;  
echo $company."---".$name."<br/>";  //同理输出 taobao---马云
	
$kkk = each($usersMan);  
list($company,$name) = $kkk;  
echo $company."---".$name."<br/>";  //同理输出 360---周鸿祎 到这时候each已经让指针指到了$usersMan的最后一位了

echo !(list($company,$name) = each($usersMan));   //指针已经是$usersMan的最后一位了 再each也没有了 所以list($company,$name) = each($usersMan)为false
echo "<br/>";
reset($usersMan);                   //重置数组 让指针指回初始位置

while(!!list($company,$name) = each($usersMan)){      //利用上面的分析 用这个while就可以和foreach一样遍历数组了
	echo $company."---".$name."\n";              		  //baidu---李彦宏 taobao---马云 360---周鸿祎 
}
echo "<br/>";

//array_unique() 移除数组元素中 数组元素值相同的部分
$number = array(2,3,6,9,5,2,2,3,3,5,6);
$mmm = array_unique($number);   //移除数组元素值相同的数组元素
print_r($mmm);     //Array ( [0] => 2 [1] => 3 [2] => 6 [3] => 9 [4] => 5 ) 
echo "<br/>";
$nnn = array_flip($mmm);        //交换数组的键和值
print_r($nnn);    //Array ( [2] => 0 [3] => 1 [6] => 2 [9] => 3 [5] => 4 ) 
echo "<br/>";
	
//数组里面包数组 形成二维三维数组
$products = array(
	array("猪肉",6,32.3),
	array("牛肉",4,22.6),
	array("苹果",11,39.1)
);
print_r($products);    
//Array ( [0] => Array ( [0] => 猪肉 [1] => 6 [2] => 32.3 ) [1] => Array ( [0] => 牛肉 [1] => 4 [2] => 22.6 ) [2] => Array ( [0] => 苹果 [1] => 11 [2] => 39.1 ) ) 
echo "<br/>";
echo $products[0][0]."\n".$products[0][1]."\n".$products[0][2]."<br/>".   //猪肉 6 32.3   形成表格
		 $products[1][0]."\n".$products[1][1]."\n".$products[1][2]."<br/>".	  //牛肉 4 22.6
		 $products[2][0]."\n".$products[2][1]."\n".$products[2][2]."<br/>";   //苹果 11 39.1
echo "<br/>";
	
for($i=0 ; $i<count($products) ; $i++){            //双重循环也能输出上面的表格
	for($j=0 ; $j<count($products[$i]) ; $j++){
		echo $products[$i][$j]."\n";
	}
	echo "<br/>";
}
echo "<br/>";

for($i=0 ; $i<count($products) ; $i++){       //也能输出如上表格  
	foreach($products[$i] as $aaa=>$bbb){     //第二层循环时循环array里面的array 假如第二层array使用了自定义下标 而不是0 1 2之类的
		echo $bbb."\n";                       //那就使用foreach了
		reset($products[$i]);  //这里在下面还要用each($products[$i]所以每次输出完毕 就让$products[$i]指针指回到初始地方 
	}                                         //如果不reset($products[$i]); 那后续用each($products[$i]就没作用了
	echo "<br/>";
}
echo "<br/>";

for($i=0 ; $i<count($products) ; $i++){            //也能输出如上表格  
	while(!!list($aaa,$bbb)=each($products[$i])){  //第二层循环时循环array里面的array 假如第二层array使用了自定义下标 而不是0 1 2之类的
		echo $bbb."\n";                            //那就使用list each也可以
	}
	echo "<br/>";
}
echo "<br/>";
		
//sort()排序
$fruit = array("bananer","orange","apple");
sort($fruit);         //注意是先对$fruit排序 再打印$fruit这个变量
print_r($fruit);   		//Array ( [0] => apple [1] => bananer [2] => orange ) 
echo "<br/>";

$num = array(21,33,1,5,36,47);
sort($num);
print_r($num);       //Array ( [0] => 1 [1] => 5 [2] => 21 [3] => 33 [4] => 36 [5] => 47 ) 
echo "<br/>";

$strings = array("21","33","1","5","36","47");
sort($strings,SORT_STRING);    //按照数字字符串排序 如果不设置这个参数 就相当于参数 SORT_NUMERIC按数字自然大小排序
print_r($strings);   //Array ( [0] => 1 [1] => 21 [2] => 33 [3] => 36 [4] => 47 [5] => 5 ) 
echo "<br/>";

$num2 = array(21,331,5,1);
asort($num2);          //值排序 但是键还是原来的键
print_r($num2);        //Array ( [3] => 1 [2] => 5 [0] => 21 [1] => 331 ) 
echo "<br/>";
echo "<br/>";

$mms = array(1,2,3,4);
shuffle($mms);              		//随机交换数组的位置
//$mms1 = array_reverse($mms);  //反转数组属性 也就是为4 3 2 1了 注意一般array开头的会生成新数组 如果用这句那下面就要改成$mms1[$i]了
for($i=0 ; $i<count($mms) ; $i++){
	echo '<img src="img/mm'.$mms[$i].'.jpg" style="margin-left:10px;"/>';
}
echo "<br/>";

//array_unshift array_push array_shift array_pop array_rand
$boys = array("aa","bb");
print_r($boys);
echo "<br/>";

$arr1 = array_unshift($boys,"cc");  //在数组的前面插入数组元素
echo $arr1;            //返回值是数组长度 3
echo "<br/>";
print_r($boys);       //Array ( [0] => cc [1] => aa [2] => bb ) 
echo "<br/>";

$arr2 = array_push($boys,"dd");    //在数组的后面插入数组元素
echo $arr2;                        //返回值是数组长度 4
echo "<br/>";
print_r($boys);      //Array ( [0] => cc [1] => aa [2] => bb [3] => dd ) 
echo "<br/>";

$index1 = array_rand($boys,1);     
echo $index1;
echo "<br/>";
$index2 = array_rand($boys,2);   //随机获取2个下标 那$index就是一个新数组了 
echo $index2[0];
echo $index2[1];
echo "<br/>";

//each() reset() current() next() prev() count() sizeof()
$some = array("第零个","第一个","第二个","第三个");
echo current($some)."\n";     //当前指针指向的值 第零个
echo next($some)."\n";        //当前指针下移一步指向的值 第一个
echo current($some)."\n";     //当前指针已经指向第一个 所以这个打印还是 第一个 
echo prev($some)."\n";        //当前指针上移一步指向的值 第零个
echo current($some)."\n";     //第零个
echo count($some)."\n";       //4
echo sizeof($some)."\n";      //同上 一般用上面的
echo "<br/>";

//array_count_values() 
$other = array(22,62,22,55,62,6,22);   //同级数组元素中某个值出现的个数
print_r(array_count_values($other));   //Array ( [22] => 3 [62] => 2 [55] => 1 [6] => 1 ) 
echo "<br/>";

//把下标转换为变量 并将值赋值给下标
// $another = array("a"=>111,"b"=>222,"c"=>333);
// extract($another);   //通过它 下标变成了变量$a 然后把对于的值111赋给了变量$a
// echo $a."\n";
// echo $b."\n";
// echo $c."\n";    //111 222 333 


?>

