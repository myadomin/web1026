<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>linux shell 命令行</title>
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
本文主要介绍linux shell 常用命令行

<p class="title">1：linux下的目录</p>
/home 每个用户分配一个目录 例如/home/adomin
/opt 自己安装的文件
/user/share 系统已安装的文件
/var 数据库文件  如果安装的xampp那数据库文件在/opt/lampp/var/mysql
wget下载的文件默认下载到当前工作目录 浏览器下载的文件默认浏览器下载路径 其他在/home用户文件夹下

<p class="title">2：常用命令</p>
data 获取当前日期
cal 当前月份日历
df 磁盘剩余空间
free 剩余内存
type 对某个命令的说明  例如 type cd 输出cd是shell内嵌  type ll 输出ll是`ls -alF'的别名
help 得到命令的帮助文档 例如 help cd 输出cd的用法格式
history 列出历史操作
exit 结束终端会话
clear 清空屏幕
ctrl+z  退出当前执行状态
ping 参看网络连接状态  例如 ping 192.168.1.33  ctrl+c停止
ifconfig 参看内网外网ip地址
getconf LONG_BIT 查看服务器是32位还是64位
cat /etc/issue 查看是ubuntu还是centos等发行版本
cat /proc/cpuinfo 查看cpu信息
cat /proc/meminfo 查看内存信息

<p class="title">3: 上传下载</p>
rz 上传本地文件
unzip 解压文件 例如unzip abc.zip
apt-get install xxx1 安装xxx1软件（ubuntu系统） 
apt-get remove xxx1 卸载xxx1软件（ubuntu系统）
yum install xxx1 安装 （centos系统）
yum erase xxx1 卸载 （centos系统）
ftp url 下载
wtp url 下载

<p class="title">4：目录查看</p>
ls  列出目录 例如ls f* 列出当前目录下f开头的目录 类似echo f*
ls -li 列出详细目录 带文件指针
ll  列出详细目录 例如ll f??? 列出当前目录下fxxx的目录及文件
cd  更改当前目录 如果当前目录是/根目录 那cd home/adomin/.pki就是到达绝对路径/home/adomin/.pki
cd -  更改目录到先前的目录
cd ~adomin  更改目录到用户adomin的主目录 一般是绝对路径/home/adomin
cd /  更改目录到根目录
pwd  显示绝对路径 例如/home/adomin/.pki  根目录/下的home文件夹下的.pki文件夹
.. 当前目录的父目录 例如cd ..就是返回到当前目录的父目录
.  当前目录 例如cd ./adomin/.pki 就是跳到当前目录的子目录中的adomin文件夹下的.pki文件夹 一般./可以省略掉
locate  查找文件或目录 例如locate -i docs/index 就会把所有的doc并且下级是xxindexxx的目录或文件列出来 -i不区分大小写

<p class="title">5：文件目录操作</p>
ubuntu等系统终端中 左键选中复制选中文本 中键黏贴到当前光标处  secureCRT等ssh中 左键复制 右键黏贴
file 文件名  确定文件类型
less 文件名  浏览文件内容
vi 文件名  如果文件没有就创建 如果文件存在就编辑 安装vim后可以用vim xx编辑文件
vi的模式切换 进入就是一般模式 按下i进入编辑模式 esc后进入命令模式 :wq保存并推出文件 
安装vim-gtk后复制左键选中 黏贴右键 查找/xxx 按n查找下一个
>  创建文件  例如>foo.html 就是创建foo.html文件
mkdir  创建目录  mkdir dir1 当前目录下创建一个dir1的目录  mkdir dir1 dir2 dir3创建三个目录
rm  删除文件  rm doc1删除文件doc1  
rm -r 删除目录  rm -r dir1 删除dir1目录(删除目录必须-r) 
rm -rf dir1 doc1 删除dir1目录 doc1文件 并且不提示(f)
cp doc1 doc2 复制doc1文件到doc2文件 如果doc2存在就覆盖doc2 如果doc2不存在就创建doc2
cp doc1 doc2 dir3复制doc1 doc2文件到dir3目录(dir3目录必须存在)
cp -r dir1 dir2 dir3复制dir1 dir2目录到dir3目录（如果dir3不存在就创建）
mv doc1 doc2  移动doc1文件到doc2文件 doc2存在就覆盖doc2 doc2不存在就创建doc2 doc1最终消失 相当于doc1重命名为doc2
mv doc1 doc2 dir1 移动doc1 doc2到dir1 dir1必须存在 doc1 doc2最终消失
mv -r dir1 dir2 移动dir1到dir2目录里 dir1最终消失 
ln doc1 doc1-aa 创建doc1文件的硬链接
ln -s doc1/abc doc2 当前目录的doc1/abc文件或目录 映射为当前目录的符号链接doc2
*  匹配0个或多个 例如ll f* 列出当前目录下f开头的目录及文件
?  匹配1个 例如ll g???l* 列出当前目录下gxxx1开头的目录及文件

<p class="title">6：权限</p>
root@adomin-virtual-machine:/# 代表当前用户是root用户(超级管理员) 当前机器是adomin-virtual-machine 如果当前用户不是root时 就是$
例如ll后一个文件或目录是-rwxrw-r-- 共10位 
第一位：-一个普通文件  d一个目录  l一个符号链接  
第二到四位：root用户 文件所有者权限 rwx代表可读可写可操作
第五到七位：组用户权限
第八到十位：其他用户权限
chmod 更改文件权限  例如chmod 777 abc 就是让abc文件形成-rwxrwxrwx
chown 更改文件所有者
chgrp 更改文件组所有权 
su 切换用户 例如su adomin 切换到用户adomin  su root切换到超级管理员 需要输入root密码
sudo 以超级管理员的身份来执行命令 另外sudo -i也是切换到超级管理员
id 显示当前用户的gid uid 组等信息
pwd 重置root密码
</pre>
</body> 
</html>    
      
     
     
     