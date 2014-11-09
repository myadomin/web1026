//历史管理 主要用于单页面应用 必须服务器环境


//方法一：利用location.hash读写及onhashchange事件 比较常用
window.onload = function(){
	var oDiv1 = document.getElementById('div1');
	var oBtn1 = document.getElementById('btn1');
	var json = {};

	oBtn1.onclick = function(){
		var arr = randomArr(35, 7);	 
		oDiv1.innerHTML = arr;	

		var randomNum = Math.random();
		window.location.hash = randomNum;	//随机数randomNum作为url的hash值#xxx 这样就有浏览器后退功能了
		json[randomNum] = arr;				//保存key是当前randomNum的value值为当前arr数组
	}

	window.onhashchange = function(){		//当点击浏览器后退按钮时 触发事件
		var hashStr = (window.location.hash).substring(1);	//得到当前hash值字符串
		oDiv1.innerHTML = json[hashStr];					//提取key值为当前hash值字符串的value
	}
}


//方法二：利用history.pushState写入及onpopstate事件  
/*window.onload = function(){
	var oDiv1 = document.getElementById('div1');
	var oBtn1 = document.getElementById('btn1');
	var json = {};

	oBtn1.onclick = function(){
		var arr = randomArr(35, 7);	 
		oDiv1.innerHTML = arr;	

		history.pushState(arr, '');		//arr被历史管理存入 后续读取用ev.state
	}

	window.onpopstate = function(ev){	//当点击浏览器后退按钮触发		 
		oDiv1.innerHTML = ev.state;		//通过ev.state读取存入历史管理的arr
	}
}*/


//随机不重复 提取数组(长度为all)中的checkNumge个数组元素 组成新数组arr2
function randomArr(all, checkNum){
	var arr1 = [];	
	var arr2 = [];
	
	for(var i=0; i<all; i++){				//形成arr1 = [1,2,3.....34,35]的数组
		arr1[i] = i+1;
	}
	
	for(var i=0; i<checkNum; i++){			//在arr1数组中随机抽取7个数组元素放入arr2中
		//arr1.splice()方法会改变原数组arr1 返回值是被剔除的数组元素组成的数组 压入到数组arr2中
		//不能用all代替arr1.length 因为每次循环后 要动态变化arr1.length保证随机索引最大值递减1
		arr2.push(arr1.splice(Math.floor((arr1.length)*(Math.random())), 1));
	}

	return arr2;
}


