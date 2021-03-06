//ajax处理多用户留言本

//请求guestbook/index.php接口 相应的url请求返回相应的json数据 具体查看common.php
window.onload = function(){

	var oReg = document.getElementById('reg');
	var oLogin = document.getElementById('login');
	var oSendBox = document.getElementById('sendBox');
	var oUsername1 = document.getElementById('username1');
	var oMsg = document.getElementById('verifyUserNameMsg');
	var oPassword1 = document.getElementById('password1');
	var oBtnReg = document.getElementById('btnReg');
	var oUser = document.getElementById('user');
	var oUserInfo = document.getElementById('userinfo');
	var oUsername2 = document.getElementById('username2');
	var oPassword2 = document.getElementById('password2');
	var oBtnLogin = document.getElementById('btnLogin');
	var oLogout = document.getElementById('logout');
	var oContent = document.getElementById('content');
	var oBtnPost = document.getElementById('btnPost');
	var oList = document.getElementById('list');
	var oPaging = document.getElementById('paging');


	//刷新进来 根据是否登录 决定界面的显示
	updateUserStatus();
	

	//刷新进来就ajax请求 获取留言列表总页数 进行分页
	ajax(
		'get',
		'guestbook/index.php',
		'm=index&a=getList&page=1&n=10',
		function(str){
			var json = JSON.parse(str);
			//形成分页
			page({
				id: 'paging',
				nowNum: 1,
				allNum: json.data.pages,
				//arg1就是nowNum的属性值(当前页)  arg2就是allNum属性值(总共页)
				//传入不同的nowNum值 allNum值 形成不同的页码形态 回调函数arg1 arg2参数用于处理应用
				callBack: function(arg1, arg2){	
					// alert('当前页：' + arg1 + ' ，总共页' + arg2);
					//根据封装好的page函数 在函数的最后给每个生成的页码a都加了onclick事件
					//之后点击任何一页 在onclick事件里继续调用page函数 page函数继续回调callBack 
					//这里的arg1动态变化成之后点击的当前页 
					//然后调用showPage 根据arg1的值 ajax请求显示当前页	
					//刷新进来的当前页是1 显示第一页
					showPage(arg1);
				}
			});
		}
	);


	//ajax验证用户名是否已注册
	oUsername1.onblur = function(){
		//index.php的API说明见common.php
		ajax(
			'get', 
			'guestbook/index.php', 
			//通过get发送data 所以是附加在url上 如果oUsername1.value出现& /等url特定字符串 就转义
			'm=index&a=verifyUserName&username=' + encodeURIComponent(oUsername1.value), 
			function(str){
				//根据不同的oUsername1.value 输出不同的json形式的字符串str "{"code":xxx, "message":xxx}"
				var json = JSON.parse(str);			//如果要兼容IE6 使用json2.js 
				oMsg.innerHTML = json.message;		//输出message到oMsg
				if(json.code){						//根据不同的json.code oMsg不同颜色
					oMsg.style.color = 'red';
				}else{
					oMsg.style.color = 'green';		//可以注册的用户名 绿色
				}
			}
		);		
	}


	//ajax提交注册
	oBtnReg.onclick = function(){
		ajax(
			'post', 
			'guestbook/index.php', 
			'm=index&a=reg&username='+oUsername1.value+'&password='+oPassword1.value, 
			function(str){
				var json = JSON.parse(str);
				if(!json.code){
					alert(json.message + '请登录');
				}else{
					alert(json.message);
				}	
			}
		);
	}


	//ajax用户登录
	oBtnLogin.onclick = function(){
		ajax(
			'post',
			'guestbook/index.php',
			'm=index&a=login&username='+oUsername2.value+'&password='+oPassword2.value,
			function(str){
				var json = JSON.parse(str);
				alert(json.message);
				//登录后更新界面
				updateUserStatus();
			}
		);
	}


	//点击退出 删除cookie
	oLogout.onclick = function(){
		ajax(
			'get',
			'guestbook/index.php',
			'm=index&a=logout',
			function(str){
				var json = JSON.parse(str);
				alert(json.message);
				//退出后更新界面
				updateUserStatus();
			}
		);
	}


	//发表留言 并生成一条留言
	oBtnPost.onclick = function(){
		ajax(
			'post',
			'guestbook/index.php',
			'm=index&a=send&content=' + oContent.value,
			function(str){
				var json = JSON.parse(str);
				alert(json.message);
				if(!json.code){
					createMessage(json.data, true);
				}
			}
		);
	}


	//根据登录情况 更新界面
	function updateUserStatus(){
		if(getCookie('uid')){
			oReg.style.display = 'none';
			oLogin.style.display = 'none';
			oUser.style.display = 'block';
			oUserInfo.innerHTML = '欢迎：' + getCookie('username');
		}else{
			oReg.style.display = 'block';
			oLogin.style.display = 'block';
			oUser.style.display = 'none';
		}
	}


	//显示留言列表第几页
	function showPage(pageNow){
		ajax(
			'get',
			'guestbook/index.php',
			'm=index&a=getList&page='+pageNow+'&n=10',
			function(str){
				var json = JSON.parse(str);
				if(json.data){
					oList.innerHTML = ''; 
					for(var i in json.data.list){
						//循环 把当前页的所有条数的留言都显示出来
						createMessage(json.data.list[i], false);
					}
				}else{
					//一刷新进来的第一页就没有留言 不显示分页
					if(pageNow == 1){
						oList.innerHTML = '还没有留言，你可以速度来卖个萌';
						oPaging.style.display = 'none';
					}
				}
			}
		);
	}
	

	//生成一条留言
	function createMessage(data, insert){
		var oDl = document.createElement('dl');
		oDl.innerHTML = '<dt>'+
							'<strong>'+data.username+'</strong> 说 :'+
						'</dt>'+
						'<dd>'+data.content+'</dd>'+
						'<dd class="t">'+
							'<a href="javascript:;" id="support">顶(<span>'+data.support+'</span>)</a>|'+
							'<a href="javascript:;" id="oppose">踩(<span>'+data.oppose+'</span>)</a>'+
						'</dd>';
		//如果是发表留言 传入的insert是true 然后在最前面插入这条留言 
		if(insert && oList.children[0]){
			oList.insertBefore(oDl, oList.children[0]);
		}else{
			//如果是一刷新进来的生成留言列表 传入的insert是false 不需要前插入
			//因为后台在数据库查询的时候是DESC降序查询 所以后留言的会先查出 
			//所以这里直接appendChild就能后留言的显示在前面了 不需要insertBefor
			oList.appendChild(oDl);
		}
	}
	

}


//获取cookie属性值
function getCookie(name){                  
	var arr = document.cookie.split("; ");   
	for(var i=0 ; i<arr.length ; i++){
		var arr2 = arr[i].split("=")        
		if(arr2[0]==name){                  
			return arr2[1];                   
		} 	
	}
	return "";
}


//js分页函数封装 详细封装见js分页函数封装及应用
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

	//给所有页码加上点击事件 点击任何页码再次调用page()
	var aA = obj.getElementsByTagName('a');
	for( var i=0; i<aA.length; i++ ){
		aA[i].onclick = function(){
			var clickNum = parseInt(this.getAttribute('href').substring(1));
			obj.innerHTML = '';			//清空所有a 

			page({						//再次调用page()	
				id: options.id,
				nowNum: clickNum,		//cliclkNum作为新的nowNumValue
				allNum: allNum,         //allNum由上面callBack传递过来
				callBack: callBack  	//回调函数
			});

			return false;
		}
	}
}


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
