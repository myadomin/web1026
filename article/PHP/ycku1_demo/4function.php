<?php
//函数

//之前用的 echo md5() print_r() 等都是系统标准函数 手册里的都是标准函数  除了系统标准函数 我们也可以自定义函数
function functionAa(){
	echo "我是一个自建函数，我没有参数，没有返回值<br/>";
}
functionAa();              //函数调用不区分大小写 functionaa()和这个一样

function functionArea($radius=1){    //如果没有传入参数 就默认为1 如果有传参 那$radius就是传入的参数
	$area = $radius * $radius * pi();
	return $area;
}
echo "半径为5米的圆的面积是：".functionArea(5)."平方米<br/>";   //传参
echo "面积是：".functionArea()."平方米<br/>";                   //不传参 就是默认的1 所以是 面积是：3.14159265359平方米

function functionInfo($name,$age,$job){
	$userInfo = array($name,$age,$job);
	return $userInfo;
}
print_r(functionInfo("luo","30","coder"));  //Array ( [0] => luo [1] => 30 [2] => coder ) 
echo "<br/>";
list($name,$age,$job) = functionInfo("luo","30","coder");
echo $name."||".$age."||".$job."<br/>";     //luo||30||coder

//关于按值传递参数
$price = 50;
$tax = 0.5;
function functionPrices($price,$tax){
	$price = $price * $price;
	$tax = $tax * $tax;
	echo $price."<br/>";         //2500
	echo $tax."<br/><br/>";      //0.25
} 
functionPrices($price,$tax);   //按值传参数进去 此时参数就算写成$aaa $bbb也没关系 只要函数内做相应的更改就可以     
echo $price."<br/>";           //50  函数内部的$price变化是局部作用域的 出了函数就不影响了 所以影响不了这里的$price
echo $tax."---<br/><br/>";     //0.5
  
//超级全局变量
$GLOBALS["a"] = 5;
function fa(){
	$GLOBALS["a"] = 2;
}
fa();
echo $GLOBALS["a"];    //2 本来函数内部的变量是局部的 这里应该访问不到2 但是现在这个变量是 $GLOBALS["a"]超级全局变量了 任何地方都能访问
echo "<br/>";
  
//调用自建的函数库
// include "xxx/xxx/xxx.php"   //假如我在此路径下放了一个php文档 文档里面有很多自建的函数 通过这句就相当于加载了这些函数到现在这里来
// echo function xx1();        //假设上面的php文档里面就有一个自建的 xx1函数 这时候就可以直接调用了              
// 其实include的作用就是 将xxx/xxx/xxx.php内部的全部内容 全部放到现在这个地方来 如果这个php内部除了函数还有其他的文字之类的也会体现到现在这里来
// include "file.txt";           //把这个文档的所有内容都放到现在这里来了 所以执行完这句现在的页面就多了this is my php 这些东西 php同理
// include "file.txt";           //再执行一次 就又再多一句this is my php；
// include_once "file.txt";      //只包含一次 
// include_once "file.txt";      //在写也不包含了
// require "file.txt";           //功能同include 推荐用这个 因为如果文件名不存在他会报错 include不会
// require_once "file.txt";      //功能同include_once; 
// echo "<br/>";
 
//魔法常量
echo __FILE__;      		   //注意前面是两个下划线 C:\AppServ\www\phpStudy\4function.php  路径常量
echo "<br/>";
echo dirname(__FILE__);    //C:\AppServ\www\phpStudy 目录
echo "<br/>";
echo dirname(__FILE__).'\file.txt';   //注意这里必须单引号了 否则会认为\是转义字符 C:\AppServ\www\phpStudy\file.txt
echo "<br/>";
//require dirname(__FILE__).'\file.txt';  //this is my php  以后可以用这种方式 采用绝对路径引用文档

echo __LINE__;                          //68 当前行数
echo "<br/>";

function fff(){
	return __FUNCTION__;    //返回当前函数名  
}   
echo fff();          			//fff


?>













