<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>discuz二次开发</title>
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
本文主要介绍discuz二次开发

<p class="title">一：discuz大致架构</p>
 ┬── api 外部接口
 │      ├── connect 腾讯互联
 │      ├── db UCenter数据库备份接口
 │      ├── google Google引擎使用
 │      ├── javascript 数据和广告的 JS调用
 │      ├── manyou manyou应用及搜索等相关服务
 │      └── trade 在线支付接口
 ├── archiver 论坛静态化
 ├── config 站点配置文件
 ├── data 数据缓存及附件
 │      ├── attachment 上传的文件目录
 │      │      ├── album 相册专用
 │      │      ├── block DIY专用
 │      │      ├── common 公共上传
 │      │      ├── forum 论坛附件专用
 │      │      ├── group 群组图标和头部图片专用
 │      │      ├── portal 门户上传文件专用
 │      │      ├── profile 个人资料专用
 │      │      └── temp 临时文件
 │      ├── avatar 视频认证专用
 │      ├── backup 站点数据备份
 │      ├── cache 数据缓存 **common.css通过缓存最终在这里生成style_1_common.css**
 │      ├── diy DIY模块缓存 **&lt!--[diy=diy1]-->&ltdiv id="diy1" class="area">&lt/div>&lt!--[/diy]-->最终解析缓存在这**
 │      ├── ipdata Discuz!IP库
 │      ├── log 站点日志，前/后台管理日志、错误日志等
 │      ├── plugindata 插件缓存数据
 │      ├── template 模板缓存目录
 │      └── threadcache 帖子缓存
 ├── install 安装目录
 ├── source 代码主目录
 │      ├── admincp 后台程序
 │      │      ├── cloud Discuz!云平台
 │      │      ├── menu 菜单
 │      │      └── moderate 审核功能
 │      ├── archiver 论坛静态化功能代码
 │      ├── class 类文件目录
 │      │      ├── adv 站点广告功能
 │      │      ├── block DIY模块功能文件
 │      │      ├── cache 缓存类
 │      │      ├── db 数据库类
 │      │      ├── discuz discuz类 **初始定义了$_G等全局变量**
 │      │      ├── forum 论坛
 │      │      ├── helper 存放从function_core分离出来的一部分函数
 │      │      ├── lib 工具类的集合类
 │      │      ├── magic 道具
 │      │      ├── memory 内存类
 │      │      ├── secqaa 验证问答
 │      │      ├── table 数据表操作类
 │      │      └── task 站点任务功能
 │      ├── function 函数文件
 │      │      └── cache 缓存功能拆分目录
 │      ├── include 被包含的文件
 │      │      ├── collection 淘帖
 │      │      ├── cron 计划任务
 │      │      ├── misc 杂项
 │      │      ├── modcp 前台论坛管理
 │      │      ├── portalcp 前台门户管理
 │      │      ├── post 帖子相
 │      │      ├── search 搜索功能
 │      │      ├── space 家园和个人相关功能
 │      │      ├── spacecp 个人设置相关
 │      │      ├── table 编码转换数据
 │      │      ├── thread 查看主题相关
 │      │      └── topicadmin 前台主题管理
 │      ├── language 站点语言包
 │      │      ├── adv 广告
 │      │      ├── block DIY模块
 │      │      ├── forum 论坛
 │      │      ├── group 群组
 │      │      ├── home 家园
 │      │      ├── magic 道具
 │      │      ├── member 登录注册页面语言
 │      │      ├── mobile 手机访问功能语言
 │      │      ├── portal 门户语言
 │      │      ├── ranklist 排行榜语言
 │      │      ├── search 搜索
 │      │      ├── secqaa 安全问答
 │      │      ├── tag 标签
 │      │      ├── task 任务
 │      │      └── userapp manyou应用
 │      ├── module 功能模块
 │      │      ├── connect 腾讯互联
 │      │      ├── forum 论坛
 │      │      ├── group 群组
 │      │      ├── home 家园
 │      │      ├── member 登录注册
 │      │      ├── misc 杂项
 │      │      ├── portal 门户
 │      │      ├── search 搜索
 │      │      └── userapp 应用
 │      └── plugin 插件目录
 │              ├── cloudstat Discuz!云平台
 │              ├── myapp Manyou应用
 │              ├── myrepeats 马甲功能
 │              ├── qqconnect 腾讯互联
 │              └── soso_smilies 腾讯搜搜表情
 ├── static 非PHP文件 **所有的图片 js 等内容**
 │      ├── image 界面图片
 │      ├── js 站点JS脚本
 │      ├── space 空间皮肤
 │      └── topic 门户皮肤
 ├── template 模板目录
 │      └── default 默认风格  ***参考二*
 ├── uc_client UCenter客户端程序


<p class="title">二：mystyle新建模板 目录解析</p>
所有的二次开发都是新建修改这个目录(某文件在default对应有的就读default 没有就读这里)
主要是如下三个部分的修改开发
mystyle
┬── common 第一部分：公共htm css修改
│      ├── common.css  全局样式  最终缓存到data-cache-style_x_common.css
│      ├── module.css  模块样式  最终缓存到data-cache-style_x_forum_index.css(forum版块的index模块)
│      ├── extend_common.css  继承修改全局样式
│      ├── extend_module.css  继承修改模块样式
│      ├── header.htm  头部修改
│      ├── footer.htm  尾部修改
│ ├── pubsearchform.htm 。。。其他default模板对应文件修改
├── forum 第二部分：帖子列表 帖子详情页修改
│      ├── forumdisplay.htm  帖子列表页
│      ├── forumdisplay_list.htm  帖子列表
│      ├── forumdisplay_subforum.htm  发帖
│      ├── viewthread.htm  帖子详情页
│      ├── viewthread_fastpost.htm  帖子详情页快速发帖
│      ├── viewthread_node.htm 。。。 其他default模板对应文件修改
├── protal 第三部分：建立频道(门户) 例如入口discuz/abc/  **参考三**
│      ├── list_abc.htm  建立某个频道页映射到abc项目
│      ├── abc  abc项目文件夹(已开发好的静态页面)
│      │   ├── css
│      │   ├── js
│      │   ├── img
│      │   ├── xxx
├── discuz_style_mystyle.xml  模板配置 界面-风格管理-修改默认风格为mystyle模板
├── preview.jpg    
├── preview_large.jpg
├── diy  diy各模块配置 非必须
│     ├── xxx1.xml
│     ├── xxx2.xml 。。。


<p class="title">三：建立频道banban 入口discuz/banban/  改静态网页 抓取台帖子数据</p> 
1: template下新建文件夹mystyle 放入discuz_style_mystyle.xml 配置如下四项
&ltitem id="name">&lt![CDATA[mystyle]]>&lt/item>
&ltitem id="templateid">&lt![CDATA[3]]>&lt/item>
&ltitem id="tplname">&lt![CDATA[mystyle套系]]>&lt/item>
&ltitem id="directory">&lt![CDATA[./template/mystyle]]>&lt/item>
&ltitem id="copyright">&lt![CDATA[adomin]]>&lt/item>
2：后台-风格管理-启用模板 编辑模板常用项目(更改全局)
3：新建mystyle-common-common.css及module.css(更改全局css 这里有就不去读default里的common module.css了)
4：新建mystyle-portal-list_banban.htm及文件夹banban(建立频道banban 入口discuz/banban/)
banban文件夹就是针对频道banban的项目文件夹 内部放图片 css js等文件
list_banban.htm文件类似template/default/portal/index.htm 格式如下
&lt!--{template common/header}-->
&lt!--[name]班班网频道[/name]-->
&ltstyle id="diy_style" type="text/css">&lt/style>
//这个链接静态网页写好的css
&ltlink href="template/mystyle/portal/banban/css/style.css" rel="stylesheet" type="text/css" />
&ltdiv class="wp">
//在这里放入已写好的各部分html 
&lt!--[diy=diy1]-->&ltdiv id="diy1" class="area">&lt/div>&lt!--[/diy]-->
&lt/div>
&ltscript src="misc.php?mod=diyhelp&action=get&type=index&diy=yes&r={echo random(4)}" type="text/javascript">&lt/script>
&lt!--{template common/footer}-->
5：门户-频道栏目-添加频道 
目录名称:banban  列表页模板名:班班网频道(就建立了list_banban.htm与入口discuz/banban/的映射) 
选择在导航显示 选择都可以查看该频道
6：界面 - 导航设置 - 主导航 改动班班网的显示位置
7: 把自己写好的静态页面某个模块用&lt!--[diy=diy1]-->&ltdiv id="diy1" class="area">&lt/div>&lt!--[/diy]-->替换
然后diy拖入模块 模块-编辑-数据-模块模板 将此模块的静态html放入 并用{xxx}等开始替换 抓取论坛帖子数据
8：参考官网http://faq.comsenz.com/library/diy/diyapp/diyapp_index.htm (css link链接是错误的)


<p class="title">四：抓取论坛数据 </p>
在写html的时候 插入&lt!--[diy=diy1]-->&ltdiv id="diy1" class="area">&lt/div>&lt!--[/diy]-->就会出现一个diy框架
或者打开diy高级模式 然后新建框架-拖入帖子模块 模块-编辑-数据-模块模板 在里面自己写html
某些区域不需要抓取帖子信息 就采用静态模块 新建框架-拖入静态模块 模块-编辑-数据-自定义html  
引入如下变量就是抓取对应帖子的相应字段信息
数据ID {id}
帖子URL {url}
帖子标题 {title}
附件图片 {pic}
帖子内容 {summary}
楼主 {author}
楼主UID {authorid}
楼主头像 {avatar}
楼主头像(中) {avatar_middle}
楼主头像(大) {avatar_big}
版块URL {forumurl}
版块名称 {forumname}
主题分类名称 {typename}
主题分类图标 {typeicon}
主题分类URL {typeurl}
分类信息名称 {sortname}
分类信息URL {sorturl}
总发帖数 {posts}
今日发帖数 {todayposts}
最后回复时间 {lastpost}
发帖时间 {dateline}
回复数 {replies}
总浏览数 {views}
热度值 {heats}
推荐数 {recommends}
更多链接 {moreurl}
当前数据顺序 {currentorder}
当前数据是否在奇数行 {parity}
默认循环显示内容 [loop]...[/loop]
替代对应loop中指定数据内容，[order=odd]为奇数行，[order=even]为偶数行 [order=N]...[/order]
特殊指定数据显示内容 [index=N]...[/index]
可设置打开方式的链接 &lta href="{url}"{target}>{title}&lt/a>
可设置缩略图大小的图片 &ltimg src="{pic}" width="{picwidth}" height="{picheight}" />
更多说明... 请参考： 后台 - 门户 - 模块模板 - 编辑/添加模板


<p class="title">五：分类信息创建</p>
参考班班网教程5


<p class="title">六：常用语法</p>
&lt!--{template common/header}-->  调用文件 以temlate/default为根目录
&lt!--{if empty($gid)}-->  判断
&lt!--{eval $thread[tid]=$thread[closed];}-->  eval后 按照php代码解析
&lt!--{loop}-->  循环
&lt!--{echo 111}-->  直接输出
&lt!--{hook/index_top}-->  钩子
&lt!--[diy=diy3]-->&ltdiv id="diy3" class="area">&lt/div>&lt!--[/diy]-->  模板
$_G['uid'] 判断是否登录
$_G['basescript'] == 'portal' 这是门户代
$_GET['diy'] == 'yes' 是否diy状态
全局变量 $_G 参考discuz\source\class\discuz\discuz_application.php


<p class="title">七：技巧</p>
1: config/config_global.php里的$_config['output']['tplrefresh'] = 1; 1改成2 刷新两次页面就可以看到修改后的效果了，不用来回的更新缓存，主要用于调试模板用
2：将common.css的.frame, .frame-tab的background: {WRAPBG}去掉 那新建框架就没有背景了
</pre>
</body> 
</html>    
      
     
     
     