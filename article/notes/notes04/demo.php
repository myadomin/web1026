<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>web访问流程 apache配置</title>
<link rel="stylesheet" type="text/css" href="../../../css/article_base.css" />
<style>
p, pre{
	margin: 0px;
	padding: 0px;
}
</style>
</head>
<body>

<pre>
<p class="title">概述</p>
本文主要介绍web访问流程及apache配置

<p class="title">一：web的访问流程</p> 
1：图示
<img src="../img/04-00.png" alt="" />

2：详细过程
输入网址域名-->检测本机的hosts文件是否有设定这个域名的ip地址-->如果有就直接访问对应ip,如果没有就请求DNS服务器-->
请求dns服务器后返回此域名对应的ip地址给客服端-->客服端请求这个ip地址到对应的服务器-->tcp ip 链路层-->把http头发送到服务器-->
服务器接收到请求头-->apache根据自己的配置找到服务器对应的某个目录文件-->此文件返回给apache-->apache接收到此文件-->
如果是.html文件就直接返回客户端，如果是.php就交给php引擎解析，如果涉及数据库再通过mysql等处理-->给到apche最终处理完的html-->
apache将此html返回-->链路层 tcp ip 附带响应头和响应实体(html文件等)-->给到客户端浏览器显示
如果http请求是200 客服端就不需要http请求服务器了 直接读取本地缓存
如果http请求时304 http请求服务器只需要接收响应头 响应实体不需要 因为not modify

3：本机hosts文件具体作用 
假如在C:\Windows\System32\drivers\etc\hosts文件上写了 123.4.5.6 abc.com
根据上面的流程就是当本机输入www.abc.com后 就会先找到本机的hosts文件 然后访问的ip是123.4.5.6 而不会去dns解析域名为ip了
所以这种本机hosts的修改 只对本机访问某些指定域名才能解析成对应ip


<p class="title">二：apache的相关配置 基于windows下的appserv</p>
1：找到E:\AppServ\Apache2.2\conf\httpd.conf文件  
1）第67行 Listen 80
如果安装apache过程中没有做过特意修改 默认是80(web的默认服务就是80) 也就是外部访问www.xxx.com后 
浏览器其实真实访问的是http://www.xxx.com:80(默认域名后会都会自带上:80) 这里设置的就是监听80端口 服务器就知道了给外部提供web服务
假如把上面改成 Listen 8080 那外部访问必须是http://www.xxx.com:8080才能访问到这个服务器的web服务 所以作为服务器一般不改动这个端口为非80
假如本地开发用 那127.0.0.1:8080对应php-apache访问  127.0.0.1:8090对应java-tomcat访问  那是可以考虑该这个为非80端口的
2）第240行 DocumentRoot "e:/AppServ/www"
如果用127.0.0.1访问 那就是访问本机的e:/AppServ/www文件夹  
如果上面的Listen被改成了8080 那就是127.0.0.1:8080才能访问e:/AppServ/www
3）第233行 ServerName localhost:80
本机用127.0.0.1:80访问时 等同于localhost:80访问 等同于localhost
如果上面的Listen被改成了8080 那就需要localhost:8080去等同127.0.0.1:8080
4）&ltDirectory>xxxx&lt/Directory>
里面设置哪些ip可以访问 一般默认设置为都可以访问
5）第303行 DirectoryIndex index.php index.html index.htm
输入localhost后 就会访问localhost:80 就会访问127.0.0.1:80 就会访问e:/AppServ/www
而在e:/AppServ/www下没有指定哪个文件 通过这里的设定就会去找index.php没有就index.html没有就index.htm
如果都没找到 那就会显示此文件夹下的所有文件

2：域名映射 复杂方法 合适配置多域名
把域名解析到外网ip后 输入域名由于httpd.conf的第240行DocumentRoot "e:/AppServ/www" 
所以会访问到www文件夹 而一般我们希望访问www/项目文件夹 所以要做域名映射 访问此服务器对应的项目文件夹
1)打开E:\AppServ\Apache2.2\conf\httpd.conf  去掉Include etc/extra/httpd-vhosts.conf前面的#开启此模块
2)打开E:\AppServ\Apache2.2\conf\extra\httpd-vhosts.conf 做如下修改
通过下面的修改外网ip(也就是域名www.fuzegame.tv)就直接进入此服务器的E:\AppServ\www\fuzegame目录
&ltVirtualHost *:80>
    DocumentRoot  E:\AppServ\www\fuzegame
    ServerName fuzegame.tv  
&lt/VirtualHost>
如果还想其他的域名例如www.xxaa.com访问到此服务器的某个目录 可以再加下一段
&ltVirtualHost *:80>
    DocumentRoot  E:\AppServ\www\xxaa
    ServerName www.xxaa.com
&lt/VirtualHost>
如果做了如上修改后 输入localhost就等同于localhost:80 就会找到第一个的 E:\AppServ\www\fuzegame了
所以还需要添加一个localhost对应的路径 加上如下
&ltVirtualHost *:80>
    DocumentRoot  E:\AppServ\www
    ServerName localhost
&lt/VirtualHost>
3)：检查配置文件是否语法错误
打开windows下的cmd  输入E:\AppServ\Apache2.2\bin\httpd.exe -t  查看输出
Syntax OK就表示没错  否则查看相应错误

3：域名映射 简单方法
修改第240行 DocumentRoot "e:/AppServ/www" 加入改为"e:/AppServ/www/myweb
改完后 如果用127.0.0.1访问 那就是访问本机的e:/AppServ/www/myweb
如果购买了空间 那外网用空间ip访问 就是访问本机的e:/AppServ/www/myweb
</pre>
</body> 
</html>    
      
     
     
     