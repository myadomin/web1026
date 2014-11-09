//miaov4--JSONP--suggestion and search
//一：问题的提出
/*如果想使用ajax跨域请求其他域名从而获得数据 出于安全考虑是被限制请求不到的 
//有如下三个办法解决跨域请求数据的问题
1：服务器端文件代理请求模式
在php中请求其他域名形成数据输出 ajax请求本域下的php等服务器文件 
$url = 'http://www.xxx.com/xxx/xxx/xxx?xxx=XXXX';
$content = file_get_contents($url);
echo $content;
2：flash解决 
3：JSONP(JSON with padding) 最常用的方法 */


//二：JSONP的实现原理
/*创建script标签 通过script请求其他域名的数据<script src="其他域名url"></script> 这样就不会被限制请求
以百度suggestion搜索下拉菜单为例 在搜索框输入aa 用chrome的F12查看network Scripts请求url
请求url：http://suggestion.baidu.com/su?wd=aa&json=1&p=3&sid=7010_1448_5223_6995_7540_7443_6505_7233_6017_7202_6931_7476_7254_7134_7415&cb=jQuery110209679804856423289_1404614879375&_=1404614879378
返回可应用于jsonp的数据：jQuery110209679804856423289_1404614879375({"q":"aa","p":false,"s":["啊阿里巴巴","aaa","aabc形式的词语","aape","aa制生活","aac","aabb式的词语大全","aabc","aabc形式的成语","aaron"]});
url分析：
http://suggestion.baidu.com/su 跨域请求的域名
wd=aa 搜索的是aa
cb=jQuery110209679804856423289_1404614879375&_=1404614879378 回调函数名称
&_=1404614879378 当前时间戳 解决缓存问题
数据分析：
jQuery110209679804856423289_1404614879375 回调函数名称
jQuery110209679804856423289_1404614879375(xxx) 回调函数的参数xxx就是请求需要的数据
"s":["啊阿里巴巴","aaa",xxx,xxx]下拉suggestion的各项内容
为什么url中需要附带回调函数名称 为什么需要的数据放在回调函数的参数里 下面分析JSONP的具体实现 */


window.onload = function(){

	//三：JSONP的具体实现 先以src同域名test.php文件模拟
	var oBtn1 = document.getElementById('btn1');
	var oBtn2 = document.getElementById('btn2');
	var flag1 = flag2 = true;

	//点击请求数字按钮后 script标签src了'test.php?type=number&callback=getNumber'
	//返回了getNumber(["1111","2222","3333","4444","5555"]) 然后去执行getNumber函数 
	oBtn1.onclick = function(){
		if(flag1){		//第一次点击创建script标签 之后不再创建
			var oScript = document.createElement('script');
			oScript.src = 'test.php?type=number&callback=getNumber';
			document.body.appendChild(oScript);
		}
		flag1 = false;
	}

	//点击请求字母按钮后 script标签src了'test.php?type=letter&callback=getLetter'
	//返回了getLetter(['aaaa','bbbb','cccc','dddd','eeee']) 然后去执行getLetter函数
	oBtn2.onclick = function(){
		if(flag2){
			var oScript = document.createElement('script');
			oScript.src = 'test.php?type=letter&callback=getLetter';
			document.body.appendChild(oScript);
		}
		flag2 = false;
	}
	//结论：通过不同的callback值调用不同的函数完成不同的功能 需要的数据作为callback函数的参数



	//四：百度suggestion实例 获取真实的百度数据库数据
	//http://suggestion.baidu.com/su?wd=xxxx&cb=mysuggestion&now='+new Date().getTime()
	var oTxt1 = document.getElementById('txt1');
	var oBtn3 = document.getElementById('btn3');
	var oUl3 = document.getElementById('ul3');
	var aLi = oUl3.getElementsByTagName('li');
	var index = '';
	var initTxt = '';

	//点击百度一下 进入搜索链接 搜索的就是搜索框文字oTxt1.value
	oBtn3.onclick = function(){
		location.href = "http://www.baidu.com/s?wd="+encodeURIComponent(oTxt1.value);
	}

	//输入框onkeyup事件
	oTxt1.onkeyup = function(ev){
		//如果是回车 进入相应链接 搜索的就是oTxt1.value 后续不再执行
		if(ev.keyCode == 13){
			location.href = "http://www.baidu.com/s?wd="+encodeURIComponent(oTxt1.value);
			return;
		}

		//出现下拉suggestion后 按键盘向上键 不进行后续的JSONP请求 不形成新的下拉suggestion
		if(ev.keyCode == 38 && aLi.length){	 
			for(var i=0; i<aLi.length; i++){
				//下拉suggestion某个li如果有鼠标hover就重置全局index 没有就仍然是initialvalue
				if(aLi[i].className == 'active'){
					index = i;
				}
				//清除所有li的class 以清除背景颜色
				aLi[i].className = '';
			}

			//如果没有li被hover过 index没有被上面重置 那第一次按向上键 suggestion最后一个变背景色
			if(index == 'initialvalue'){
				index = aLi.length;
			}

			//一直按向上键 按到第一个li的下一个 index重置为initialvalue
			//并且输入框内容就是最开始打字输入的内容 下面的不在执行
			if(index == 0){
				index = 'initialvalue';
				oTxt1.value = initTxt;
				return;
			}
			
			//递减当前index 给相应li加背景 更新输入框内容 
			index--;
			aLi[index].className = 'active';
			oTxt1.value = aLi[index].innerHTML;
			return;
		}

		//出现下拉suggestion后 按键盘向下键 不进行后续的JSONP请求 不形成新的下拉suggestion
		if(ev.keyCode == 40 && aLi.length){	 	

			for(var i=0; i<aLi.length; i++){
				if(aLi[i].className == 'active'){
					index = i;
				}
				aLi[i].className = '';
			}

			if(index == 'initialvalue'){
				index = -1;
			}

			if(index == aLi.length-1){
				index = 'initialvalue';
				oTxt1.value = initTxt;
				return;
			} 

			index++;
			aLi[index].className = 'active';
			oTxt1.value = aLi[index].innerHTML;
			return;
		}

		//开始JSONP请求前初始化index initTxt
		index = 'initialvalue';
		initTxt = oTxt1.value;

		//JSONP请求百度数据库 得到搜索下拉suggestion的数据
		var jsonpScript = document.getElementById('jsonp');	
		if(jsonpScript){		//每次keyup后删除上一次创建的用于jsonp的script标签
			document.body.removeChild(jsonpScript);
		}
		var oScript = document.createElement('script');
		//wd是输入的搜索关键字 cd是自定义的回调函数 now解决缓存问题 通过src请求后
		//就可以得到百度的数据库数据 返回mysuggestion({q:"搜索内容",s:["xx","xx","xx"..]})
		//然后自定义mysuggestion函数 把s的内容放入下拉suggestion中去
		oScript.src = 'http://suggestion.baidu.com/su?wd='+oTxt1.value+'&cb=mysuggestion&now='+new Date().getTime();
		oScript.id = 'jsonp';
		document.body.appendChild(oScript);
	}



	//五：利用豆瓣API接口 搜索豆瓣商品
	//'http://api.douban.com/book/subjects?q='xx'&alt=xd&callback=showList&start-index=0&max-results=10&now='+new Date().getTime();
	//q:搜索关键字  alt=xd&callback=showList:以showList(xxx)的JSONP形式返回数据
	//start-index:第几条数据开始显示  max-results:共显示多少条数据
	var oBtn4 = document.getElementById('btn4');
	var oTxt2 = document.getElementById('txt2');
	var oPaging = document.getElementById('paging'); 
	//回车 获取第一页也就是第0-10条数据
	oTxt2.onkeyup = function(ev){
		if(ev.keyCode == 13){
			oPaging.innerHTML = '';
			getPageData(1);
		}	
	}
	//点击豆瓣搜索 获取第一页也就是第0-10条数据
	oBtn4.onclick = function(){
		oPaging.innerHTML = '';
		getPageData(1);
	}

}


//JSONP得到test.php数据后 回调函数处理
function getNumber(data){
	var oUl1 = document.getElementById('ul1');
	var html = '';
	for(var i in data){
		html += '<li>我是数字'+ data[i] +'</li>';
	}
	oUl1.innerHTML = html;
}
function getLetter(data){
	var oUl2 = document.getElementById('ul2');
	var html = '';
	for(var i in data){
		html += '<li>我是字母'+ data[i] +'</li>';
	}
	oUl2.innerHTML = html;
}


//JSONP得到百度数据data后 对数组data.s进行操作
function mysuggestion(data){
	var oTxt1 = document.getElementById('txt1');
	var oUl3 = document.getElementById('ul3');
	var aLi = oUl3.getElementsByTagName('li');
	var html = '';

	//遍历data.s数组 形成li
	for(var i in data.s){
		html += '<li>'+ data.s[i] +'</a></li>';
	}
	oUl3.innerHTML = html;
	
	//给每个li加移入移出及点击事件
	for(var i=0; i<aLi.length; i++){
		aLi[i].onmouseenter = function(){
			this.className = 'active';
		}
		aLi[i].onmouseleave = function(){
			for(var i=0; i<aLi.length; i++){
				aLi[i].className = '';
			}
		}
		aLi[i].onclick = function(){
			oTxt1.value = this.innerHTML;
			location.href = "http://www.baidu.com/s?wd="+encodeURIComponent(oTxt1.value);
		}
	}
}


//JSONP得到豆瓣第pageNum页的数据 也就是第(pageNum-1)*10条到第(pageNum-1)*10+10条的数据
function getPageData(pageNum){
	var oTxt2 = document.getElementById('txt2');
	var jsonpScript = document.getElementById('doubanScript');	
	if(jsonpScript){		//每次keyup后删除上一次创建的用于jsonp的script标签
		document.body.removeChild(jsonpScript);
	}
	var oScript = document.createElement('script');
	oScript.src = 'http://api.douban.com/book/subjects?q='+oTxt2.value+'&alt=xd&callback=showList&start-index='+(pageNum-1)*10+'&max-results=10&now='+new Date().getTime();
	oScript.id = 'doubanScript';
	document.body.appendChild(oScript);
}


//获取豆瓣数据后 形成搜索结果列表及分页
function showList(data){
	console.log(data);
	var oList = document.getElementById('list');
	var oMsg = document.getElementById('msg');
	var html = '';

	//显示共搜索出多少条 opensearch:totalResults不是标准变量写法 所以用中括号字符串的方式获取
	oMsg.innerHTML = data.title['$t'] + '：共' + data['opensearch:totalResults']['$t'] + '条';

	//形成搜索结果列表
	for(var i in data.entry){
		html += '<dl><dt>'+data.entry[i].title["$t"]+'</dt><dd><img src="'+data.entry[i].link[2]["@href"]+'"/></dd></dl>';
	}
	oList.innerHTML = html;

	//分页 不需要加回调函数
	page({
		id: 'paging',
		nowNum: Math.floor(data['opensearch:startIndex']['$t']/10) + 1,
		allNum: Math.ceil(data['opensearch:totalResults']['$t']/data['opensearch:itemsPerPage']['$t'])
	});

} 


//js分页函数封装 
//在之前封装好的标准分页函数上做了修改 没有在aA[i].onclick = function(){}里继续回调Page
//而是执行了getPageData(clickNum) getPageData函数中就有page(也不要加回调) 所以aA中不要继续回调page
function page(options){
	//必传参数id
	if( !options.id ){		
		return false;
	}
	var obj = document.getElementById(options.id);
	//选传参数 不传就是默认 
	var nowNum = options.nowNum || 1;		//当前页
	var allNum = options.allNum || 5;		//总页数
	var callBack = options.callBack || function(){};	//回调函数

	//首页 上一页 部分
	if( nowNum >= 4 && allNum >=6 ){
		var oA = document.createElement('a');
		oA.href = '#1';
		oA.innerHTML = '[首页]';
		obj.appendChild(oA);
	}
	if( nowNum >= 2){
		var oA = document.createElement('a');
		oA.href = '#' + (nowNum - 1);
		oA.innerHTML = '[上一页]';
		obj.appendChild(oA);
	}

	//页码 1 2 3 4 5...部分 只显示5个页码数字
	if( allNum <= 5 ){					//总页数小于等于5页 
		for( var i=1; i<=allNum; i++ ){	//产生allNum个a
			var oA = document.createElement('a');
			oA.href = '#' + i;
			if( i == nowNum ){		
				oA.innerHTML = i;
			}else{
				oA.innerHTML = '[' + i + ']';
			}
			obj.appendChild(oA);
		}	
	}else{								//总页数大于5页
		for( var i=1; i<=5; i++ ){		//只产生5个a
			var oA = document.createElement('a');

			if( nowNum == 1 || nowNum == 2 ){	//当前页是1 2  
				oA.href = '#' + (nowNum - 1 + i);
				if( i == nowNum ){						 
					oA.innerHTML = i;
				}else{
					oA.innerHTML = '[' + i + ']';
				}								//当前页是allNum allNum-1
			}else if( nowNum == allNum || nowNum == (allNum - 1) ){	
				oA.href = '#' + (allNum - 5 + i);
				if( i == ( 5 - ( allNum - nowNum ) ) ){
					oA.innerHTML = (allNum - 5 + i);
				}else{
					oA.innerHTML =  '[' + (allNum - 5 + i) + ']';
				}
			}else{								//当前页是其他   		
				oA.href = '#' + (nowNum - 3 + i);
				if( i == 3 ){							 
					oA.innerHTML = (nowNum - 3 + i);
				}else{
					oA.innerHTML = '[' + (nowNum - 3 + i) + ']';
				}
			}
			
			obj.appendChild(oA);
		}
	}

	//... 下一页 尾页 部分
	if( allNum - nowNum >= 1 ){
		var oA = document.createElement('a');
		oA.href = '#' + (nowNum + 1);
		oA.innerHTML = '[下一页]';
		obj.appendChild(oA);
	}
	if( nowNum <= (allNum - 3) && allNum >=6 ){		//出现尾页前面必出现...
		var oA = document.createElement('a');
		var oSpan = document.createElement('span');
		oA.href = '#' + allNum;
		oA.innerHTML = '[尾页]';
		oSpan.innerHTML = '....';
		obj.appendChild(oSpan);
		obj.appendChild(oA);
	}

	//执行函数 
	//相当在参数中写好的函数function(arg1, arg2){xxx}(nowNum, allNum) 匿名函数自我执行
	callBack(nowNum, allNum);

	//给所有页码加上点击事件 点击任何页码再次调用getPageData() 获取clickNum页数据及分页 
	var aA = obj.getElementsByTagName('a');
	for( var i=0; i<aA.length; i++ ){
		aA[i].onclick = function(){
			var clickNum = parseInt(this.getAttribute('href').substring(1));
			obj.innerHTML = '';			//清空原来的分页页码a 
			getPageData(clickNum);
			return false;
		}
	}
}