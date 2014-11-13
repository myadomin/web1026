<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>linux服务器搭建</title>
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
本文主要介绍如何搭建linux php服务器

<p class="title">一：Win7下用VMwar安装Ubuntu centos</p>
1: 安装ubuntu
参考链接： http://blog.sina.com.cn/s/blog_9772ef17010179do.html
注意点：第8步 如果是笔记本无线上网 要选择第一个 use bridged networking
2: 安装centos
参考链接：http://www.jb51.net/os/85895.html
注意点：如果是笔记本无线上网 要选择第一个 use bridged networking
安装完成后是不能上网的 要做如下修改
vim /etc/sysconfig/network-scripts/ifcfg-eth0 进入文件编辑
将ONBOOT=no改为ONBOOT=yes 激活网卡。
将NM_CONTROLLED=yes改为NM_CONTROLLED=no。
将HWADDR与UUID注释或删除。
输入命令：service networt restart   （重启网络服务）
输入命令：ifconfig -a    （查看网络配置）

<p class="title">二：获取root权限</p>
1：passwd  设置root密码 需要先输入你在装系统是设置的用户名密码 然后设置root密码
2：sudo -i或者su root切换到root账户
3: 如果是centos 登陆root用户即可

<p class="title">三：安装secureCRT</p>
1: 在本机windows下安装secureCRT
2: 在虚拟机ubuntu下安装secureCRT server 
sudo apt-get install openssh-server  然后输入ps -e |grep ssh   如果安装成功就会出现ssh-agent和sshd两项
3：打开vmware - 设置 - 网络适配器 右边选择桥接模式 勾选复制物理
4：终端输入 ifconfig得到虚拟机ubuntu的eth0的inet addr （内网ip地址）
5：打开secureCRT 连接 主机名就是上面的ip地址 用户名就是你ubuntu的用户名
6：选项->全局选项->默认会话->编辑默认设置->外观->字符编码UTF-8
7：选项->全局选项->默认会话->编辑默认设置->终端 –> 反空闲 –>发送协议勾选  这样每60秒发送一次空，保证连接不断。
服务器修改/etc/ssh/sshd_config  ClientAliveInterval 300（默认为0） 然后service sshd reload 让服务器300秒发一次请求
8: 后续对虚拟机Ubuntu的操作都在本机windows下的secureCRT进行

<p class="title">四：安装xampp 注意先用getconf LONG_BIT 查看ubuntu时32位还是64位的 然后选择相应的linux xampp</p>
1: 下载xmapp  wget http://jaist.dl.sourceforge.net/project/xampp/XAMPP%20Linux/1.8.3/xampp-linux-x64-1.8.3-5-installer.run
2: 获取root权限  sudo -i 或者su root  输入你的root密码
3：移动xmapp的run包到opt目录下  mv /xampp-linux-x64-1.8.3-5-installer.run  /opt  
4：提升run包的可操作权限  chmod 755 xampp-linux-x64-1.8.3-5-installer.run   安装run包  ./xampp-linux-x64-1.8.3-5-installer.run
5：启动xampp  /opt/lampp   回车  然后 ./lampp start
6：对于centos 除了22端口可能其他端口都防火墙了 所以去掉对默认80端口的防火墙  /sbin/iptables -I INPUT -p tcp --dport 80 -jACCEPT
7：此时用外网ip例如192.168.1.xx/  是访问不了192.168.1.xx/phpmyadmin的  （可以不做）
需要修改/opt/lampp/etc/extra/httpd-xampp.conf文件
把此文件的 Require local注释掉  然后重启xampp   /opt/lampp/lampp restart  
这样外网就能通过192.168.1.xx/phpmyadmin访问phpmyadmin了
8: 此时外网访问phpmyadmin不能创建数据库 （可以不做） 
修改/opt/lampp/phpmyadmin/config.inc.php 将$cfg['Servers'][$i]['auth_type']=“cookie”的cookie改成http   
然后重启xampp   /opt/lampp/lampp restart   
以上7 8两部能不做就不做  让外网访问phpmyadmin不安全 也可能拖慢服务器速度  
一般是在本地win操作phpmyadmin 然后数据库文件放到服务器对应目录/opt/lampp/var/mysql 上    
9：设置密码  /opt/lampp   回车  然后 ./lampp security   
xampp用户名xampp  
phpmyadmin用户名pma  
mysql用户名root 
ftp用户名daemon默认端口21

<p class="title">五：域名映射</p>
把域名解析到购买的外网ip上 输入域名就进入了htdocs文件夹 而一般我们希望进入htdocs/项目文件 所以要做域名映射
1：打开/opt/lampp/etc/httpd.conf  去掉Include etc/extra/httpd-vhosts.conf前面的#开启此模块
2：打开/opt/lampp/etc/extra/httpd-vhosts.conf 做如下修改
打开域名解析到外网ip 通过下面的修改外网ip就直接进入服务器的/opt/lampp/htdocs/fuzegame目录
&ltVirtualHost *:80>
    DocumentRoot /opt/lampp/htdocs
    ServerName localhost  #输入localhost后访问的对应目录
&lt/VirtualHost>
&ltVirtualHost *:80>
    DocumentRoot /opt/lampp/htdocs/fuzegame
    ServerName fuzegame.tv  #输入www.fuzegame.tv后访问的对应目录
&lt/VirtualHost>

<p class="title">六：开发及部署</p>
1：一般在本地window的localhost下做开发测试 在本地phpmyadmin做数据库建立 
2：开发完毕后 把开发文件上传到服务器htdocs下 把数据库文件放入服务器/opt/lampp/var/mysql下 
3: 如果重启服务器 需要重新打开xampp /opt/lampp/lampp start

补充：以上都是基于linux的php环境安装，如果是window下用xampp搭建php环境，安装xampp需要注意如下
1：下载xampp安装，启动mysql apache，由于php版本是5.5以上的，所以需要安装vc11才能启动apache。
2：mysql和phpmyadmin默认是没密码的，进入http://localhost:80/xampp/，安全，http://localhost/security/xamppsecurity.php设置密码
</pre>
</body> 
</html>    
      
     
     
     