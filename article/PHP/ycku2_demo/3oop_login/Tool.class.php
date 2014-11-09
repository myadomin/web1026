<?php

//定义工具类  此类不能被继承  都是静态方法  不需要new就能直接调用方法
final class Tool{		//与java不同  不能写成public final class Tool
	//弹出信息  跳到指定页面的静态方法
	public static function alertLocaton($info, $url){
		echo "<script type='text/javascript'>alert('$info');location.href='$url';</script>";
		exit();
	}
	
	//弹出信息  返回原页面
	public static function alertBack($info){
		echo "<script type='text/javascript'>alert('.$info.');history.back();</script>";
		exit();	
	}
}

?>