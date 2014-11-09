<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><!--{webname}--></title>
<link rel="stylesheet" type="text/css" href="demo.css"/>
<script type="text/javascript" src="demo.js"></script>
</head>
<body>

当前页数是：<!--{pagesize}--><br/>

{$name} {$content}<br/>

{if $a} 
	<div>我是一号界面</div>
{else}
	<div>我是二号界面</div>
{/if}

{#}我是php的注释{#}

{foreach $array(key,value)}
	{@key}...{@value}<br/> 
{/foreach}

{include "file"} 

</body> 
</html>    
      
     
     
     