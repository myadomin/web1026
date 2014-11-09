
//ajax瀑布流--浮动布局
window.onload = function(){
	var oDiv1 = document.getElementById('div1');
	var aUl = oDiv1.getElementsByTagName('ul');
	var flag = true;
	var batchNum = 1;

	//鼠标滚轮
	window.onscroll = function(){
		var viewHeight = getInner().height;
		var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

		for(var i=0; i<aUl.length; i++){
			var aLi = aUl[i].getElementsByTagName('li');	
			var oLastLi = aLi[aLi.length - 1];				//
			//某个ul的最后一个li出现在可视区后 就开始ajax请求新数据
			if((viewHeight + scrollTop > posTop(oLastLi)) && flag){	
				//flag开关的作用！！！！！关键点！！！！！
				//onscroll会瞬间触发多次 此时的(viewHeight + scrollTop > posTop(oLastLi))还没计算完成
				//所以只有马上改变flag才能阻止瞬间多次触发
				//所以onscroll第一次触发后flag就为flase 保证瞬间只一次ajax请求
				flag = false;

				//请求第batchNum批数据
				ajax('data.php?batch='+batchNum, function(str){
					//注意在将json字符串解析为json对象的时候 必须'('+str+')'
					//如果不加那就是eval({xxx}) eval会把{}当做语句块解析 然后报错
					//如果加了eval(({xxx})) eval就会把()内部的json解析成一个对象
					var json = eval('('+str+')');

					//遍历出所有数据 生成li
					for(var i in json.list){
						for(var j in json.list[i].src){
							var oLi = document.createElement('li');
							oLi.innerHTML = '<img src="'+ json.list[i].src[j] +'"/><p>'+ json.list[i].title[j] +'</p>';
							aUl[i].appendChild(oLi);
						}
					}

					//当次ajax请求后 再打开触发onscroll的开关 以备触发下一批次的ajax请求
					//此时已是若干秒后 (viewHeight+scrollTop>posTop(oLastLi))计算已完成 能正确用于if判断了
					if(json.batch < 10){	//第10批是最后一批 之后不再开启onscroll开关
						flag = true;
					}

					//ajax请求完毕后 批次数累加1 为下一批次数据准备
					batchNum++;
				});
			}
		}
	}
	
}


//兼容 让IE6 7 8的offsetTop也是相对窗口顶部的距离
function posTop(obj){		
	var top = 0;
	while(obj){
		top += obj.offsetTop;
		obj = obj.offsetParent;
	}
	return top;
}

//获取视窗宽度高度
function getInner(){
	if(window.innerWidth){    	//高版本各浏览器 W3C标准
		return{
			width:window.innerWidth,  
			height:window.innerHeight
		}
	}else{
		return{          		//兼容低版本IE
			width:document.documentElement.clientWidth,  
			height:document.documentElement.clientHeight
		}
	}
} 

//ajax函数封装
function ajax(url, fnSucc, fnFaild)
{
	//1.创建Ajax对象
	var oAjax=null;
	
	if(window.XMLHttpRequest)
	{
		oAjax=new XMLHttpRequest();
	}
	else
	{
		oAjax=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	//2.连接服务器
	oAjax.open('GET', url, true);
	
	//3.发送请求
	oAjax.send();
	
	//4.接收服务器的返回
	oAjax.onreadystatechange=function ()
	{
		if(oAjax.readyState==4)		//请求完成
		{
			if(oAjax.status==200)	//完成且url页面存在
			{
				fnSucc(oAjax.responseText);
			}
			else
			{
				if(fnFaild)
				{
					fnFaild(oAjax.status);
				}
			}
		}
	};
}