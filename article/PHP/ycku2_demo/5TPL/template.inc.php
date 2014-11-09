<?php

//给所有类似index.php的主php文件共用的配置文件

//设置UTF-8编码
header("Content-type:text/html; charset=utf-8");

// echo __FILE__."<br/>";		//C:\AppServ\www\phpStudy\ycku2_demo\5TPL\index.php	当前文件硬路径
// echo dirname(__FILE__);		//C:\AppServ\www\phpStudy\ycku2_demo\5TPL 硬路径的目录

//定义常量ROOT_PATH为根目录 (C:\AppServ\www\phpStudy\ycku2_demo\5TPL)
define('ROOT_PATH', dirname(__FILE__));
//模板文件目录常量
define('TPL_DIR', ROOT_PATH.'/templates/');
//编译文件目录常量
define('TPL_C_DIR', ROOT_PATH.'/templates_c/');
//缓存文件目录常量
define('CACHE', ROOT_PATH.'/cache/');
//是否开启缓存
define('IS_CACHE', true);
IS_CACHE ? ob_start() : null;

//引入模板类  实例化模板类
require ROOT_PATH.'/includes/Templates.class.php';
$_tpl = new Templates();

?>