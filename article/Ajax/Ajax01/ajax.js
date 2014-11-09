//封装ajax函数  
function ajax(method, url, data, fnSucc) {
	//1.创建ajax对象
	var xhr = null;

	//IE低版本兼容
	//不可以直接判断XMLHttpRequest 因为XMLHttpRequest是变量 不事先定义就直接使用 浏览器会报错
	//所以判断window.XMLHttpRequest 因为window.XMLHttpRequest是属性 没有事先定义直接执行就是undefined再转换为false 
	if(window.XMLHttpRequest){
		xhr = new XMLHttpRequest();
	}
	else{
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	//2.规定请求的类型、URL 以及是否异步处理请求。
	//open(method,url,async) 
	//规定请求的类型、URL 以及是否异步处理请求。
	//•method：请求的类型；GET 或 POST
	//•url：文件在服务器上的位置
	//•async：true（异步）或 false（同步）
	//get方式 把data附到url后面发送到服务器  
	if (method == 'get' && data) {
		url += '?' + data;
	}
	xhr.open(method,url,true);
	
	//3.将请求发送到服务器。
	//send(string) 
	//string：如果GET请求就不需要输入string 如果是POST请求就输入sting 
	if (method == 'get') {
		xhr.send();
	} else {	
		//post方式 data通过send发送到搭配服务器
		xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
		xhr.send(data);
	}
	
	//4.接收返回 OnReadyStateChange(每当readyState属性改变时触发)
	xhr.onreadystatechange = function() {
		//readyState
		//0: 请求未初始化             
		//1: 服务器连接已建立
		//2: 请求已接收
		//3: 请求处理中
		//4: 请求已完成，且响应已就绪
		if ( xhr.readyState == 4 ) {
			//status 
			//200: "OK"
			//404: 未找到页面
			if ( xhr.status == 200 ) {
				//请求成功 执行回调函数 返回的数据作为回调函数参数
				fnSucc(xhr.responseText);
			} else {
				alert('出错了,Err：' + xhr.status);
			}
		}
	}

}