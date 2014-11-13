<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>微信公众平台开发相关</title>
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
本文主要介绍微信公众平台开发相关

<p class="title">一：ngrok的使用 基于windows</p>
1：为什么要使用ngrok
在微信开发的时候 需要填写与微信服务器相连接的url 这个url必须是外网域名，
也就是说我们需要在这个外网域名对应的ip服务器上做开发，而没办法本地开发调试
所以用ngrok获得一个外网域名 这个外网域名实际访问的是本地主机
这样把此外网域名填入到微信需要的外网url里 就可以在本地开发调试了
2：下载ngrok https://ngrok.com/ windows版 
3：注册ngrok 得到your auth token 后面的自定义域名必须要有这个token
4: 打开cmd cd到ngrok.exe在的目录，执行ngrok 80 就可以给你本机的127.0.0.1:80分配一个外网可以访问的域名 例如http://1f1b1c.ngrok.com
也就是外网访问http://1f1b1c.ngrok.com 就是访问你本机的127.0.0.1:80，当然如果你执行ngrok 8080 那就是分配一个域名访问127.0.0.1:8080
5: 上面分配的域名是临时的，可能下次开电脑这个域名就变化了，我们需要一个固定的域名映射到本机的80端口
所以先登录 执行ngrok -authtoken XUsFLvG4hgb8ukjvML8YBXX 80 这里填写的是你注册时给你的token，
然后ngrok -subdomain myapp 80 这样后续你通过http://myapp.ngrok.com 就可以一直访问到本机的127.0.0.1:80了
当然如果是想访问的是8080端口 那就把上面的80都改成8080
6：不要关闭cmd窗口 关闭后提供的域名就访问不了了 如果要查看ngrok给你做的中转http信息 访问http://localhost:4040/
7：具体到微信的开发 一定要注意 由于是ngrok做的中转 出于安全考虑通不过微信的默认语句libxml_disable_entity_loader(true);
所以注释掉他 等正式部署到服务器再取消注释 
</pre>
</body> 
</html>    
      
     
     
     