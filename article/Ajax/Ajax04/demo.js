
//Ajax瀑布流--最终版本
window.onload = function(){
	var aUl = document.getElementById('div1').getElementsByTagName('ul');
	var flag = true;
	var pageNum = 0;


	//刷新进入 开始加载第0页数据
	getDatas();


	//滚动 看情况加载数据
	window.onscroll = function(){
		var oUlShort = aUl[getShortUlIndex()];
		var viewHeight = document.documentElement.clientHeight;
		var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

		//一直滚动 当最短的列还差500px就要出现在可视区的时候 就开始请求下一批数据
		if((oUlShort.offsetHeight + getTop(oUlShort) + 500) < (viewHeight + scrollTop) && flag){
			//flag开关的作用！！！！！关键点！！！！！
			//onscroll会瞬间触发多次 此时的可视区判断计算还没完成
			//所以只有马上改变flag才能阻止瞬间多次触发
			//所以onscroll第一次触发后flag就为flase 保证瞬间只一次ajax请求
			flag = false;
			getDatas();
		}
		
	}


	//ajax获取数据 函数封装
	function getDatas(){
		ajax('get', 'getPics.php', 'cpage='+pageNum, function(data){
			//请求的数据是网络上压缩好的数据包 没有接口文档 所以也不知道是数组还是其他类型
			//可以用chrome F12 network preview工具查看排列好的数据格式 可以看出是字符串数组

			//var arr = eval('('+data+')');	//解析字符串 这里是字符串数组 解析出的就是数组对象
			var arr = JSON.parse(data);		//功能同上 更加安全 一般用这个 但是IE6 7不支持 所以引入json2文件兼容 

			for(var i in arr){
				//生成<li><img src="xxx" /><p>xxx</p></li> 
				var oImg = document.createElement('img');
				oImg.src = arr[i].preview;
				//由于加载src需要一定的时间 而下面的index计算会立刻进行 如果不在这里马上先设定好高度的话
				//那可能下面立刻计算出的index并不是实际的当前最短列 所以先设定好高度保证下面的index是正确值
				oImg.style.width = '220px';
				oImg.style.height =  data[i].height*(220/data[i].width) + 'px';
				var oP = document.createElement('p');
				oP.innerHTML = arr[i].title;
				var oLi = document.createElement('li');
				oLi.appendChild(oImg);
				oLi.appendChild(oP);

				//生成的li 放入到此次循环时最短的列ul下面 这样就保证了各图片即使高度相差太大 每列高度也差别不大
				var index = getShortUlIndex();
				aUl[index].appendChild(oLi);
			}

			//ajax请求完成 再打开触发onscroll的开关 以备触发下页的ajax请求
			//此时已是若干秒后 可视区计算判断已完成 能正确用于if判断了
			if(arr.length){		//如果arr.length等于0 说明没数据了 那就不开启开关了 
				flag = true;
			}

			//ajax请求完毕后 页数累加1 为下一批次数据准备
			pageNum++;
		});
	}


	//获取当前高度最小的ul是第几个ul
	function getShortUlIndex(){
		var index = 0;
		var iHeight = aUl[0].offsetHeight;
		for(var i=1; i<aUl.length; i++){
			if(aUl[i].offsetHeight < iHeight){
				index = i;
				iHeight = aUl[i].offsetHeight;
				
			}
		}
		return index;
	}


	//获取obj对象相对窗口最顶部的偏移
	function getTop(obj) {
		var iTop = 0;
		while(obj) {
			iTop += obj.offsetTop;
			obj = obj.offsetParent;
		}
		return iTop;
	}


	//ajax函数封装
	function ajax(method, url, data, success) {
		var xhr = null;
		try {
			xhr = new XMLHttpRequest();
		} catch (e) {
			xhr = new ActiveXObject('Microsoft.XMLHTTP');
		}
		
		if (method == 'get' && data) {
			url += '?' + data;
		}
		
		xhr.open(method,url,true);
		
		if (method == 'get') {
			xhr.send();
		} else {
			xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
			xhr.send(data);
		}
		
		xhr.onreadystatechange = function() {
			if ( xhr.readyState == 4 ) {
				if ( xhr.status == 200 ) {
					success && success(xhr.responseText);
				} else {
					alert('出错了,Err：' + xhr.status);
				}
			}
			
		}
	}


}

