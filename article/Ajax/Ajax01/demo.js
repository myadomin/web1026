//ajax的封装与应用


//一：封装ajax函数 -----------------------------------------------
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



//二：ajax应用 -----------------------------------------------
window.onload = function(){

	//1：由于每次请求的url都是aaa.txt 这个url被get请求后浏览器可能会将内容缓存下来
	//那下次就算改变了aaa.txt内容 ajax再请求aaa.txt的时候 因为请求url和上次一样 
	//那就会优先读取第一次存下来的缓存 这样就没办法及时刷新了 为了解决这个问题 
	//需要每次都请求不同的url同时文档还是aaa.txt文档 所以url变为aaa.txt?t=当前时间戳
	var oBtn1 = document.getElementById("btn1");
	oBtn1.onclick = function(){ 
		//请求任何文件后缀的文件都可以 甚至请求aaa.xxx文件也可以 
		//只要aaa.xxx在浏览器能输出 请求到的就是aaa.xxx在浏览器的输出
		ajax("get", "aaa.txt", "t="+new Date().getTime(), function(str){     
			alert(str);                                                
		})
	}


	//2：原生eval()方法 将字符串里面的内容进行解析内容形式是什么就变什么类型  
	var oBtn2 = document.getElementById("btn2");
	var oBtn3 = document.getElementById("btn3");
	oBtn2.onclick = function(){     
		ajax("get", "array.txt", "t="+new Date().getTime(), function(data){                                            
			alert(typeof data);         	//string 字符串类型
			alert(data[0]);       			//[ 字符串的第一个字符         
			//Ajax请求文本的内容是数组字符串[1,2,3,4] 经过eval后就变成数组 
			var arr = eval(data);          
			alert(arr instanceof Array);  	//true 因为经过eval以后 变成了数组
			alert(arr[0]);             		//这就能正确读取出数组的第0个元素1了
		})
	}	

	oBtn3.onclick = function(){     
		ajax("get", "json.txt", "t="+new Date().getTime(), function(str){    
			//Ajax请求文本的内容是json格式组成的数组字符串[{"a":"12", "b":5},{"c":"1", "d":3}]	
			arr = eval(str);             
			alert(arr[0].a);    	//正确读取出数组的第0个元素（也就是第一个json）的下标a的值 
			alert(arr[1].c)           
		})
	}


	//3：但是出于安全性考虑 ajax请求到的数据一般不会用eval()方法解析
	//主要是用JSON.stringify() JSON.parse()进行数据解析 IE67下不支持JSON对象(可以引入json2.js兼容)
	var arr1 = [1,2,3];
	var obj1 = {left:100};
	// 通过JSON.stringify()方法 将数组等对象转为字符串
	// alert(typeof JSON.stringify(arr1));   
	// alert(typeof JSON.stringify(obj1));

	var str1 = '[100,200,300]';
	var str2 = '{"left":200}';            
	// alert(JSON.parse(str1) instanceof Array);  	//通过JSON.parse()方法 将字符串转为数组对象    
	// alert(JSON.parse(str1));            
	// alert(typeof JSON.parse(str2).left);    		//通过JSON.parse()方法 将字符串转为json格式对象       


	//4:利用ajax读取文档 创建用户列表  
	var aA = document.getElementById("user").getElementsByTagName("a");
	var oUl = document.getElementById("user").getElementsByTagName("ul")[0];
	
	for(var i=0 ; i<aA.length ; i++){
		aA[i].index = i;
		aA[i].onclick = function(){        
			oUl.innerHTML = "";             
			ajax("get", "page"+(this.index+1)+".txt", "t="+new Date().getTime(), function(data){   
				var arr = eval(data);  
				//请求数据解析后为对象数组[{user:"ddd",pass:654},{user:"eee",pass:22},{user:"fff",pass:554}]                             
				for(var i=0 ; i<arr.length ; i++){                
					var oNewLi = document.createElement("li");       
					oNewLi.innerHTML = "user:"+arr[i].user+"||pass:"+arr[i].pass    
					oUl.appendChild(oNewLi);                   
				}
			});
			return false;
		}
	}


	//5：每秒钟向后台发送一次ajax请求 每秒钟局部刷新 及时展现后台的最新数据
	sendRequest(); 
	//每隔1秒钟执行一次sendRequest函数 记得参数是执行函数sendRequest 不是执行函数的结果sendRequest()                
	setInterval(sendRequest,1000);   
	
	//ajax向demo.php请求数据
	function sendRequest(){         
		ajax("get", "demo.php", "t="+new Date().getTime(), function(data){ 
			//返回的data是json格式的数组字符串 同时JSON.parse(data)解析为json格式数组 
			var arr = JSON.parse(data);  
			var html="";
			var oUl = document.getElementById("ul1");
			for(var i=0; i<arr.length; i++){             
				//alert(arr[i].date);
				html += "<li>"+arr[i].title+"["+arr[i].date+"]</li>";   
			}
			oUl.innerHTML = html;               
		}); 
	}


}

