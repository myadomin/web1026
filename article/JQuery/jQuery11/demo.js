
//下拉菜单
$(function(){

	//下拉菜单插件封装详情见jquery.nav.js
	$(".nav").nav({
		"sec": 300, 
		"background": "black"	//选传参数
	}).click(function(){		//保持链式调用方法
		alert(11);
	});		

});

