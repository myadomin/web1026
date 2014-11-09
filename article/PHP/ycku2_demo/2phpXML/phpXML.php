<?php
//XML操作
header("Content-type:text/html; charset=utf-8");

//1：单引号和双引号的区别
/* $_a = 5;
$_string1 = 'this is $_a';
$_string2 = "this is $_a";
echo $_string1;    //this is $_a 单引号不能解析变量
echo '<br/>';      //单引号 双引号 都可以解析HTML标签
echo $_string2;    //this is 5   双引号可以解析变量 */


//2：生成my.xml(注意_xml这四个单词的前后不能有任何空格)
/* $_xml = <<<_xml
<?xml version="1.0" encoding="utf-8"?>
<root>
	<version>1.0</version>
	<info>xml解析测试</info>
	<user>
		<name>瓢城Web俱乐部</name>
		<url>http://www.yc60.com</url>
		<author sex="男">李炎恢</author>
	</user>
	<user>
		<name>北风网</name>
		<url>http://www.ibeifeng.com</url>
		<author sex="女">谁谁谁</author>
	</user>
	<user>
		<name>电驴</name>
		<url>http://www.verycd.com</url>
		<author sex="男">姓黄的</author>
	</user>
</root>
_xml;

$_sxe = new SimplexmlElement($_xml);   	//创建一个simplexml对象，传入xml字符串
$_sxe->asXML("my.xml");              	//这样就再磁盘中创建了一个my.xml文件   */


//3：读取XML文档
/* $_sxlf = simplexml_load_file("my.xml"); //载入则个xml文档
echo $_sxlf->asXML();                 	//在浏览器中输出 asXML()中不传参数就可以 文本形式
echo "<br/><br/>";
print_r($_sxlf);                        //数组形式
echo "<br/><br/>";
var_dump($_sxlf);                       //对象形式  */


//4：读取XML节点内容
/* $_sxlf = simplexml_load_file("my.xml");			//载入XML文档
echo $_sxlf->version[0] . "<br/>";			
echo $_sxlf->user[1]->url[0] . "<br/>";
echo $_sxlf->user[2]->author[0]->attributes(); 	//获取节点属性 */


//5：利用Xpath 读取XML节点内容
/* $_sxlf = simplexml_load_file("my.xml");
$_version = $_sxlf->xpath("/root/version");  //获得类数组
echo $_version[0];
$_name = $_sxlf->xpath("/root/user/name");   //获取类数组 取得所有的name标签节点
echo $_name[1];
$_author = $_sxlf->xpath("/root/user/author");  //获取类数组 取得所有的author标签节点
echo $_author[1] -> attributes(); */


//6：利用DOMDocument 读取XML节点  了解
/* $_doc = new DOMDocument();
$_doc->load("my.xml");
$_version = $_doc->getElementsByTagName("version");
echo $_version->item(0)->nodeValue;
$_name = $_doc->getElementsByTagName("name");
echo $_name ->item(1)-> nodeValue;   */


?>