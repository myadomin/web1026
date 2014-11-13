<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>memcache的安装及使用</title>
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
本文主要介绍memcache的安装及使用

<p class="title">一：Windows下的Memcache安装：</p>
1. 下载memcache的windows版，解压放某个盘下面，比如在c:\memcached，官网只有linux版了，所以windows找个老版本用。
2. 在终端（也即cmd命令界面）下输入 'c:\memcached\memcached.exe -d install' 安装。
3. 再输入：'c:\memcached\memcached.exe -d start' 启动。NOTE: 以后memcached将作为windows的一个服务每次开机时自动启动。这样服务器端已经安装完毕了。
4. 下载对应php版本的php_memcache.dll扩展，本机TS及VC版本通过查看phpinfo的PHP Extension Build得知。
5. 在你的php\php.ini 末尾加入一行 'extension=php_memcache.dll'，把php_memcache.dll放入你的php\ext文件夹下。
6. 重新启动Apache，然后查看一下phpinfo，如果有memcache，那么就说明安装成功！

<p class="title">二：Memcache环境测试：</p>
运行下面的php文件，如果有输出This is a test!，就表示环境搭建成功。
&lt?php
$mem = new Memcache;
$mem->connect("127.0.0.1", 11211);
$mem->set('key', 'This is a test!', 0, 60);
$val = $mem->get('key');
echo $val;
?>

<p class="title">三：memcache的基本设置：</p>
例如cmd中输入：c:\memcached\memcached.exe -d restart 重起memcached服务
-p 监听的端口
-l 连接的IP地址, 默认是本机
-d start 启动memcached服务
-d restart 重起memcached服务
-d stop|shutdown 关闭正在运行的memcached服务
-d install 安装memcached服务
-d uninstall 卸载memcached服务
-u 以的身份运行 (仅在以root运行的时候有效)
-m 最大内存使用，单位MB。默认64MB
-M 内存耗尽时返回错误，而不是删除项
-c 最大同时连接数，默认是1024
-f 块大小增长因子，默认是1.25
-n 最小分配空间，key+value+flags默认是48
-h 显示帮助

<p class="title">四：memcache的使用 connect set get replace delete flush</p>
&lt?php
    //初始化Memcache的对象
    $mem = new Memcache;

    //连接服务器端
    //第一个参数是服务器的IP地址(例如本地主机127.0.0.1)
    //第二个参数是Memcache的开放端口(通过phpinfo查看，一般是11211)
    $mem->connect("127.0.0.1", 11211);

    //保存数据到Memcache服务器上
    //第一个参数是数据的key
    //第二个参数是需要保存的数据内容value
    //第三个参数是一个标记，一般设置为0或者MEMCACHE_COMPRESSED就行了
    //第四个参数是缓存的有效期，单位是秒。如果设置为0，则是永远有效
    $mem->set('key1', 'This is first value', 0, 60);

    //保存数组到Memcache服务器上
    $arr = array('aaa', 'bbb', 'ccc', 'ddd');
    $mem->set('key2', $arr, 0, 60);
    $val2 = $mem->get('key2');
    print_r($val2);
    echo "&ltbr/>";

    //从Memcache服务器获取一条数据
    $val = $mem->get('key1');
    echo "Get key1 value: " . $val."&ltbr/>";

    //用replace方法来替换掉上面key1的值
    //replace方法的参数跟set是一样的，不过第一个参数key1是必须是要替换数据内容的key
    $mem->replace('key1', 'This is replace value', 0, 60);
    $val = $mem->get('key1');
    echo "Get key1 value: " . $val."&ltbr/>";

    //删除一个数据 参数就是一个key
    $mem->delete('key1');
    $val = $mem->get('key1');
    echo "Get key1 value: " . $val . "&ltbr>";

    //清除所有Memcache上的数据，关闭连接
    $mem->flush();
    $val2 = $mem->get('key2');
    echo "Get key2 value: ";
    print_r($val2);
?>
</pre>
</body> 
</html>    
      
     
     
     