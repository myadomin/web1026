<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HTTP协议及WEB优化</title>
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
1：本文主要依据《高性能网站建设指南》及网上资料，进行web优化的个人总结。

2：需要的工具：firebug网络查看，firebug Yslow插件。

3：需要的知识：HTTP基础知识，不熟悉的朋友建议阅读《图解HTTP》。

4：下列优化手段，越排前面的投入产出比越高。 
	
<p class="title">手段一：减少HTTP请求</p> 
1：为什么要减少HTTP请求？
书中作者贴图查看了10大网站的HTTP请求时序图，结论是接收文件的时间其实很少，主要时间花在等待及阻塞文件请求上。
所以减少总时间的有效方法就是减少HTTP请求。下面介绍减少HTTP请求的具体方法。

2：利用图片热点(不常用)
用一张图做背景，通过热点在不同的图片区域附上不同的a链接。而不是每个a链接都独立用一张图片做背景。
这样假如有4个a链接就只需要一张图而不是四张图，就只有一个HTTP请求而不是四个。
局限性：如果a链接背景是一张大图那此方法合适。
如果a链接背景是一些小图标，没必要为了小图标做一个大图来铺到所有a链接的下面，建议用下面的css sprites

3：利用css sprites(常用)
什么是css sprites：把很多小图片整合放到一张大图上，例如把icon1.png icon2.png等都整合到大图global.png上，
如果需要icon1.png那css就是background: url(../img/global) no-repeat left top，
其中left是icon1在大图的-X坐标，top是icon1在大图的-Y坐标(-Y代表负数Y坐标) 
为什么要css sprites：假如某页面有icon1.png .... icon100.png共100个小图片，如果不用css sprites那需要100HTTP请求。
如果使用css sprites只需HTTP请求一张大图global.png，之后所有小图引用background: url(../img/global) no-repeat left top，
都不再需要HTTP请求，只需要读取已缓存的global.png。

4：合并JS CSS文件
软件开发过程中，我们需要遵循模块化代码的思想。而为了减少HTTP请求我们需要把多个JS CSS文件合并到一起。如何解决这个冲突？
一般在实际开发过程中遵循模块化思想，在网站上线部署的时候再进行JS CSS的文件合并。
可以手动复制合并，也可以采用Gruntjs等构件工具(具体操作见博文 <a target="_blank" href="http://localhost:8080/myweb/article/javascript/jsBase20/index.html">JS模块化开发</a>)

<p class="title">手段二：利用CDN(内容发布网络)</p> 
什么是CDN：把你的服务器分散到世界各地，用户请求的服务器是离他地理位置最近的服务器，从而提高HTTP响应速度
有钱就花钱买，没钱找免费的用。另外看了阿里云的介绍，好像阿里云服务器也能智能连接地理位置最近的服务器。

<p class="title">手段三：避免无效的src href等HTTP请求</p> 
比如img src了一个不存在的地址 那HTTP请求会在客户端与服务器端往返两次 浪费了时间

<p class="title">手段四：利用好缓存</p> 
1：缓存的好处
利用firebug网络查看工具，客户在第一次进入网站的时候，HTTP请求文件的响应状态码是200(OK)，
再次进入网站，部分文件的响应状态码是200(BFCache)，读取的是缓存，没有发送HTTP请求，所以总时间减少了很多。

2：如何设置缓存
可添加Expires请求头或设置Cache-Control:max-age:xxx(设置了max-age就会覆盖之前的Expires)，从而读取缓存。
Cache-Control:max-ag=0或负值，浏览器会在对应的缓存中把Expires设置为1970-01-01 08:00:00。
Cache-Control:max-ag=xxxx，浏览器会在对应的缓存中把Expires设置为距离第一次HTTP请求的xxxx秒后
一旦缓存中Expires设置为某个时间后，这个时间之前都是读取本地缓存，而不去发起新HTTP请求。
一般HTML等经常动态变化的资源不设置Expires，图片 JS CSS等文件建议设置Expires。
如果都不设置，采用apache服务器默认设置，那HTML无Expires，css js image等一般会设置一天左右的Expires。

3：如何配置Expires
打开Apache\conf\httpd.conf文件，找到#LoadModule expires_module modules/mod_expires.so，去掉前面的#开启expires模块
在文件内添加
&ltIfModule mod_expires.c> 
ExpiresActive    on 
ExpiresDefault "access plus 10 days" 		#默认所有文件类型Expires设置为10天后
ExpiresByType text/css "access plus 1 month"  	#CSS文件类型Expires设置为一个月后
ExpiresByType text/js "access plus 30 days"  
ExpiresByType image/jpeg "access plus 1 month"  
ExpiresByType image/gif "access plus 1 month"  
ExpiresByType image/bmp "access plus 1 month"  
ExpiresByType image/png "access plus 1 month"   
&lt/IfModule> 

4：如何配置Cache-Control:max-age:xxx
打开Apache\conf\httpd.conf文件，找到#LoadModule headers_module modules/mod_headers.so，去掉前面的#开启headers模块
在文件内添加
&ltifmodule mod_headers.c> 
&ltFilesMatch ".(js|css)$">		#js css文件 Expires设置为22666666秒后
Header set Cache-Control "max-age=22666666"
&lt/FilesMatch>
&ltFilesMatch ".(png|jpeg)$">
Header set Cache-Control "max-age=111111111"
&lt/FilesMatch>
&lt/ifmodule> 


5：304(Not Modified)与200(BFCache)的区别
在某文件缓存的时候会记录Last Modified:此文件的最新修改时间。如果此文件缓存过期了，再次读取文件就会发起HTTP请求，
并且在请求头上会加上If-Modified-Since:此文件的最新修改时间，然后与原始服务器的此文件最新修改时间比对。
如果两者相等说明文件缓存之后就一直没有变化过，那就只返回304状态码，不需返回响应实体，从而提高了响应速度。
如果两者不相等那说明文件变化过需要更新了。正常请求，返回响应实体。
所以可以利用这个特性对偶尔变化的资源使用Last-Modifed做请求验证。
可以利用浏览器的F5刷新得到304(Not Modified)。注意如果地址栏重输入URL是继续读取缓存，返回的是200(BFCache)。

<p class="title">手段五：gzip压缩组件</p> 
1：为什么要gzip压缩
将HTML CSS JS等组件通过HTTP的设置，压缩为gzip来传输。传输大小能减少2/3左右，从而加快HTTP请求
注意gzip压缩的概念不等同于通过Gruntjs等插件精简掉JS空格的概念。

2：如何gzip压缩
打开Apache\conf\httpd.conf文件，找到LoadModule deflate_module modules/mod_deflate.so，去掉前面的#开启deflate模块
在文件内添加
&ltifmodule mod_deflate.c>
DeflateCompressionLevel 9   	#压缩率
AddOutputFilterByType DEFLATE text/html application/javascript
&lt/ifmodule>

3：gizp压缩带来的问题
Apache默认HTTP的配置是开启ETage的，然后开启gizp压缩后，通过firebug网络查看部分组件的ETage和If-None-Match值出现如下情况
ETage及If-None-Match都变成了"41e0000000001ce-27-4fed21c66d328"-gzip这个格式 尾部添加了gzip 
格式不正确造成If-None-Match判断失误，F5刷新得到的是200(OK)，说明发送了完整HTTP请求，而不是我们需要的304(Not Modified)。
虽然默认配置也有If-Modified-Since，他的判断正常。但是优先级低于If-None-Match。
而且ETage的生成是根据当前服务器某些特性组合成的。如果网站部署在多台服务器上那ETage值很难把握(参考《高性能网站建设指南》)
所以需要去掉ETage与If-None-Match的配合判断(查看了淘宝等大网站都去掉了ETage)。
去掉ETage的方法：打开Apache\conf\httpd.conf文件，在文件内添加
FileETage none

<p class="title">手段六：将css放在头部</p> 
在IE浏览器中为避免重绘样式，某些情况下必须等所有css文件加载完毕才开始呈现页面。
所以如果css通过link放在页面底部，那在加载HTML内容时就可能会一直白屏，直到底部css加载完毕再一次性呈现页面。
其实整个页面的加载时间差不多，但是css在底部就不能逐步呈现页面导致用户感觉页面加载太慢。
所以把css放在head，开始加载HTML内容的时候就开始逐步呈现页面。

<p class="title">手段七：把js放在页面底部</p>
css js等任何组件的下载会存在阻塞情况，所以js会阻塞之后组件的下载及拖慢页面的呈现。
所以为了不阻塞之后组件及尽快逐步呈现页面，把js放在页面底部(js不存在document.write等影响页面呈现的功能)。

<p class="title">手段八：避免使用css表达式</p>
如下类似的css表达式 在滚轮鼠标移动等任何事件下都会进行计算 从而拖慢速度 所以不要使用
width: expression(setCntr(), doucment.body.clientWidth&lt600 ? 600px : auto)

<p class="title">手段九：将js css作为外部文件</p>
虽然js css都写在HTML文档里也减少HTML请求数量，但是HTML需要动态输出内容所以是不设置缓存的。
那js css代码就没办法利用缓存，所以讲js css作为外部文件从而可以利用好缓存。

<p class="title">手段十：减少DNS查找</p>
使用Connection:Keep-Alive减少DNS查找，一般服务器已默认配置Keep-Alive
多个主机名可以并行下载多个组件，但是过多的主机名会延长DNS的查找

<p class="title">手段十一：精简JS CSS文件</p>
在Gzip压缩的基础上还能进行JS CSS文件的精简，精简的意思就是去掉文件的空格及注释，甚至替换变量名为更短的字符串(混淆)。
这样在Gzip压缩减少了2/3体积的基础上还能减少10%左右的体积。常用此类工具有：JSMin，GruntJS等(具体操作见博文 <a target="_blank" href="http://localhost:8080/myweb/article/javascript/jsBase20/index.html">JS模块化开发</a>)

<p class="title">手段十二：其他</p>
见附录：Yslow的23条建议

<p class="title">总结</p>
1：如果都采用服务器的默认HTTP配置，加载速度也不会太慢。

2：如果想把事情做的漂亮点，网站加载快一点，并且希望你服务的网站能节省一些流量。
那需要了解HTTP知识，推荐《图解HTTP》。需要总结web优化手段，推荐《高性能网站建设指南》。
然后运用firebug等插件查看并分析HTTP请求，使用Yslow等插件做优化参考。
如果具体参数值不知如何配置，那在理解的基础上，尽量参考淘宝等大流量网站的参数值。

3：如果你追求极致的优化，并且服务于超高流量的网站有这个必要。
可能需要进一步理解HTTP和优化手段。阅读《HTTP权威指南》《高性能网站建设进阶指南》(我也没读过。。。。)

<p class="title">附录：Yslow的23条建议</p>
1. 减少HTTP请求次数
2. 使用CDN
3. 避免空的src和href
4. 为文件头指定Expires
5. 使用gzip压缩内容
6. 把CSS放到顶部
7. 把JS放到底部
8. 避免使用CSS表达式
9. 将CSS和JS放到外部文件中
10. 权衡DNS查找次数
11. 精简CSS和JS
12. 避免重定向
13. 删除重复的JS和CSS
14. 配置ETags
15. 可缓存的AJAX
16. 使用GET来完成AJAX请求
17. 减少DOM元素数量
18. 避免404
19. 减少Cookie的大小
20. 使用无cookie的域
21. 不要使用滤镜
22. 不要在HTML中缩放图片
23. 缩小favicon.ico并缓存
</pre>
</body> 
</html>    
      
     
     
     