<?php

//引入这个主php的配置文件
require dirname(__FILE__).'/template.inc.php';

//调用assign()方法  变量注入  必须在调用display()方法前就注入好
global $_tpl;
$_tpl->assign('name', '张三');
$_tpl->assign('content', '是一个coder');
$_tpl->assign('a', false);
$_tpl->assign('array', array(10,11,12,13,14,15));
$_tpl->assign('file', 'forInclude.php');

//调用display()方法  最终通过.tpl模板文件生成并载入编译文件
$_tpl->display('index.tpl');

?>