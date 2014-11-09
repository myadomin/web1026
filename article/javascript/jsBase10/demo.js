//cookie 


//一：cookie函数封装 ------------------------------------------------------
//1：设置cookie的函数
function setCookie(name,value,iDay){
	var oDate = new Date();
	oDate.setDate(oDate.getDate() + iDay);
	document.cookie = name +"="+ value +";expires="+ oDate;
}
setCookie("username","abc",30);  
setCookie("username","ccc",30);  			//重新设置
setCookie("password","123",50);
setCookie("aaaa","111ssaf",50);
setCookie("bbbb","assdf",50);
// alert(document.cookie);           		//username=ccc; password=123; aaaa=111ssaf; bbbb=assdf


//2：获取cookie属性值的函数
function getCookie(name){                 	//cookie固定格式是 username=abc; password=123; aaaa=111ssaf; bbbb=assdf
	var arr = document.cookie.split("; ");  //以冒号及空格为准 切成一个数组arr=["username=abc","password=123","aaaa=111ssaf","bbbb=assdf"]
	for(var i=0 ; i<arr.length ; i++){
		var arr2 = arr[i].split("=")        //例如arr[0]就被切成 arr2=["username","abc"]
		if(arr2[0]==name){                  //判断arr2数组的第0个元素 也就是属性名 是不是等于参数
			return arr2[1];                 //如果等于就返回arr2[1] 也就是cookie属性值
		} 	
	}
	return "";								//一直没找到就返回空
}
//alert(getCookie("username"));   //abc
//alert(getCookie("password"));   //123
//alert(getCookie("aaaa"));       //111ssaf
//alert(getCookie("bbbb"));       //assdf 以上四句分别是上面已设定好的各属性名对应的属性值


//3：删除cookie的函数
function removeCookie(name){					//如果要删除属性名是name的cookie
	setCookie(name,"任意值都可以",-1);      	//那就直接设置属性名name为任意值 并昨天过期 那系统就把他删除了
}
//alert(getCookie("bbbb"));     //assdf
//removeCookie("bbbb");
//alert(getCookie("bbbb"));     //空 已删除




//二：cookie应用 ------------------------------------------------------
window.onload = function(){

	//1：利用cookie记录div停止拖拽后的位置 从而关闭页面再进入页面或刷新页面时 div还是在之前所在的位置
	var oDrag1 = new Drag('div1');         		//实例化
	
	function Drag(id){
	  	var _this = this;
	  	this.Xpos = 0;
	  	this.Ypos = 0;
		this.oDiv = document.getElementById(id);
		
		//第一进入页面还没有过鼠标抬起时就没有cookie 那就不执行这两句
		if(getCookie("记忆的横坐标")){    
			//设置过cookie后 5天内不会过期 一旦页面刷新 或者关闭页面再进入页面  
			//读取记忆的横坐标这个cookie值 他的值就是之前抬起记录下来的offsetLeft  
			//这样 距离上次抬起鼠标5天内 就算刷新或者从进页面 div初始的位置就是之前鼠标抬起的位置                         
			this.oDiv.style.left = getCookie("记忆的横坐标") + "px";   
			this.oDiv.style.top = getCookie("记忆的纵坐标") + "px";    
		}                                                         
		
		this.oDiv.onmousedown = function(ev){   
			_this.fDown(ev);
			return false; 
		};
	}
	
	Drag.prototype.fDown = function(ev){
	  var _this = this;
	  var oEvent = ev||event;   
		scrollLeft = document.documentElement.scrollLeft||document.body.scrollLeft;
	  	scrollTop = document.documentElement.scrollTop||document.body.scrollTop;
		this.Xpos = oEvent.clientX + scrollLeft - this.oDiv.offsetLeft;  
		this.Ypos = oEvent.clientY + scrollTop - this.oDiv.offsetTop;    
		document.onmousemove = function(ev){
			_this.fMove(ev);
		};
		document.onmouseup = function(){
			_this.fUp();
		};    
	}	
	
	Drag.prototype.fMove = function(ev){     
		oEvent = ev||event;    
		x = oEvent.clientX + scrollLeft - this.Xpos;    
		y = oEvent.clientY + scrollTop - this.Ypos;
		this.oDiv.style.left = x + 'px'; 
		this.oDiv.style.top = y +'px';
	}
	
	Drag.prototype.fUp = function(){
		document.onmousemove = null;
		document.onmouseup = null;
		//当第一次鼠标抬起后 就创建一个叫做记忆的横坐标的cookie属性 他的属性值就是鼠标抬起时的div左边距
		//以后每次抬起 就更新这个这个cookie属性值为此次抬起时的div左边距
		setCookie("记忆的横坐标",this.oDiv.offsetLeft,5);  
		setCookie("记忆的纵坐标",this.oDiv.offsetTop,5);   
	}
 


	//2：利用cookie记录用户名（即使关闭再进入页面或刷新页面 用户名一直在）
	var oForm = document.getElementById("form1");
	var oUser = document.getElementsByName("user")[0];
	var oBtn1 = document.getElementById("btn1");
	
	//距离最后一次提交30天内 用户重进页面或者刷新 这个输入框的值都是被记录下来的叫做the user name的cooike值
	oUser.value = getCookie("the user name");  

	oForm.onsubmit = function(){    
		//一旦用户提交表单(再次提交就是新值替换原来的the user name这个cookie值) 设置一个叫做the user name的cooike            
		setCookie("the user name", oUser.value, 30);  
	}

	oBtn1.onclick = function(){
		//一旦用户点击清除记录 那就删除那条叫做 the user name的cookie 清空输入框  
		removeCookie("the user name");              
		oUser.value = "";                            
	}

}




